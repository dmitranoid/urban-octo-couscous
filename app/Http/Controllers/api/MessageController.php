<?php

namespace App\Http\Controllers\api;

use App\Http\Resources\MessageCreatedResource;
use App\Mail\AskQuestionMail;
use App\Mail\ContactUsMail;
use App\Mail\PriceRequestMail;
use App\Models\Message;
use App\Models\MessageContactUs;
use App\Models\MessagePrice;
use App\Models\MessageQuestion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class MessageController extends Controller
{


    public function storeContact(Request $request)
    {
        $message = new MessageContactUs($request->all());
        $message->status = Message::STATUS_NEW;
        $message->save();
        $message->setAttribute('code', 'C-' . Str::padLeft((string)$message->id, 5, '0'));
        $status = $this->sendMail($message) ? Message::STATUS_MAILED : Message::STATUS_ERROR;
        $message->save();

        return MessageCreatedResource::make($message);
    }

    public function storeQuestion(Request $request)
    {
        $message = new MessageQuestion($request->all());
        $message->status = Message::STATUS_NEW;
        $message->save();
        $message->setAttribute('code', 'Q-' . Str::padLeft((string)$message->id, 5, '0'));
//          if (configuration->get('pricerequest.sendmail')) {
        $status = $this->sendMail($message) ? Message::STATUS_MAILED : Message::STATUS_ERROR;

//        }
        $message->save();
        return MessageCreatedResource::make($message);
    }

    public function storePrice(Request $request)
    {
        $data = $request->json()->all();
        $message = new MessagePrice($data);
        $message->status = Message::STATUS_NEW;
        $message->params = $data['products'] ?? [];
        $message->save();
        $message->setAttribute('code', 'PR-' . Str::padLeft((string)$message->id, 5, '0'));

        // todo load from configuration
//          if (configuration->get('pricerequest.sendmail')) {
        $status = $this->sendMail($message) ? Message::STATUS_MAILED : Message::STATUS_ERROR;
//          }
        $message->save();
        return MessageCreatedResource::make($message);
    }

    // todo move to services
    private function sendMail(Message $message ):bool
    {
        // todo get from config
        $recipients = [
            'info@etrade-ag.com',
            'it@voloshin.by',
            'dmitranoid@gmail.com',
        ];

        if ( (filter_var($message->contact, FILTER_VALIDATE_EMAIL))) {
            $recipients[] = $message->contact;
        }

        $recipientsCc = [
            'dmitranoid@gmail.com',
        ];

        $mailMessage = match ($message->type) {
            Message::MSG_CONTACT => new ContactUsMail($message),
            Message::MSG_QUESTION => new AskQuestionMail($message),
            Message::MSG_PRICE => new PriceRequestMail($message),
            default => new AskQuestionMail($message),
        };

        try {
            $result = Mail::to($recipients)
                ->cc($recipientsCc)
                ->queue(
                    $mailMessage->onQueue('emails')
                );
            logger()->info("mail [{$message->type}] add to queue" , [
                'result' => $result
            ]);
        } catch (\Exception $e) {
            logger()->error('mail add to queue error error'. $e->getMessage());
            return false;
        }
        return true;
    }

}