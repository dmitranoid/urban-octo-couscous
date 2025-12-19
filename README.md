# e-trade

## stack 
php 8.1
laravel 11
vite

## Project setup
```
composer install
npm install

// set db connection data in .env file

// create database
php artisan migrate
php db:seed

// publish admin panel resources
php artisan orchid:publish

// create admin user 
php artisan orchid:admin admin admin@mail.com H$3eff4#dFwgtRt@
php artisan orchid:admin etadmin etadmin@temp.com EG#4wg5+@50tN6sf
```

copy .env.example to .env

set database connection

DASHBOARD_DOMAIN=etrade.local
DASHBOARD_PREFIX=admin

!! after changing settings you need to run commands

```
php artisan config:clear
php artisan route:clear
```

### Compiles and hot-reloads for development
```
npm run build
```

admin dashboard

url /admin

user: admin

pass: H$3eff4#dFwgtRt@


etadmin 

EG#4wg5+@50tN6sf

## API endpoints

!!! public API endpoints starts with **/api**

response 404 - endpoint not found 

### Top menu
```
GET /api/manufacturers/menu
```
no params

return manufacturers with categories for top menu

items list and count configurated from admin panel 

### products categories manufacturers

pagination params:
page={pageNo}
perPage={perPageCount}

sorting params:
sort={field name}
direction={asc|desc}

filtring
filter[field]={filter_value}

/top endpoint has limit param & has no pagination

```
GET /api/manuacturers?filter[manufacturer_id]={manufacturer_id}&filter[category_id]={category_id}&page={pageNo}
GET /api/manufactures/top?limit={10}&sort=name/price
GET /api/manuacturers/{id}

```

```
GET /api/categories
GET /api/categories/top?limit={10}&sort=name/price
GET /api/categories/{id}
```

```
GET /api/products
GET /api/products/search?text=gfghgf
GET /api/products/top?limit={10}&sort=name/price...
GET /api/products/{id}
GET /api/products/{id}/related 
```


### search by sku && name
```
GET /api/search?str={search string}
GET /api/search?str={search string}&sort={name/price}...
```
params:
* str= search string

pagination params:
* page={pageNo}
* perPage={perPageCount}

sorting params:
* sort={field name}
* direction={asc|desc}

### create messages
contact us

if {sendemail} param used, message will be emailed to manager 
```
POST /api/messages/contact
```
params
* author: string
* contact: string (phone no) 
```
POST /api/messages/question
```
params
* author: string
* contact: string (phone no, email)
* message: string (question)
```
POST /api/messages/pricerequest
```
params
* author: string
* contact: string (phone no, email)
* message: string (question, fill with current product and quantity and price)
* products: [{product_id: (id), price:(price), qty:(quantity) }]

response 201:created
* data[{code: string}]

### page blocks

page info
```
GET /page/{slug}
```
content block
```
GET /block/{slug}
```
image
```
GET /image/{slug}
```
array of images
```
GET /images/{slug}
```
array of content blocks
```
GET /list/{slug}
```