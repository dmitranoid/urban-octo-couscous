<script setup>
import TheBreadcrumbs from "@/components/ui/TheBreadcrumbs.vue";
import Service from "@/components/pages/shipping/Service.vue";
import Country from "@/components/pages/shipping/Country.vue";
import Faces from "@/components/pages/shipping/Faces.vue";
</script>

<template>
  <section class="shipping">
    <div class="shipping__wrapper">
      <div class="container mb">
        <div class="shipping__breadcrumbs">
          <the-breadcrumbs></the-breadcrumbs>
        </div>
        <h2 class="shipping-header">{{ page.name }}</h2>
      </div>
      <img class="banner" src="@/assets/images/shipping_banner.png" loading="lazy" />

      <div class="container grid">
        <div class="sidebar">
          <ul class="heading">
            <li><a href="#main">Cost & Delivery Terms</a></li>
            <li><a href="#terms">Delivery Terms</a></li>
            <li><a href="#services">Delivery Services</a></li>
            <li><a href="#tracking">Order Tracking</a></li>
          </ul>
          <div class="help_block">
            <h3>We are always ready to help you!</h3>
            <div class="line"></div>
            <Faces/>
            <div class="contacts">
              <a class="big" href="tel:">{{ getParam(page.params, "phone") ? getParam(page.params, "phone") : '+48 794 494 350' }}</a>
              <a href="mailto:">{{ getParam(page.params, "email")  ? getParam(page.params, "email")  : 'etrade@sales.com' }}</a>
            </div>
            <div class="button">
              <a href="#">Ask a question</a>
            </div>
          </div>
        </div>

        <div class="content">
          <template v-if="page.blocks.main">
            <h1 id="main">{{ page.blocks.main.name }}</h1>
            <br>
            <div class="with_icon">
              <template v-for="block in blocks">
                <template v-if="block.params">
                  <Country v-if="isCountry(block)" :icon="block.image" :text="block.name"/>
                </template>
              </template>
            </div>
            <div v-html="page.blocks.main.content"></div>
          </template>
          <template v-else>
            <h1 id="main">We supply goods almost worldwide. You can receive the exact price and delivery time individually from our manager.</h1>
            <br>
            <div class="with_icon">
              <template v-for="block in blocks">
                <template v-if="block.params">
                  <Country v-if="isCountry(block)" :icon="block.image" :text="block.name"/>
                </template>
              </template>
            </div>
            <h2>Not included in shipping cost:</h2>
            <ul>
              <li>Product insurance (available upon request, 2% of the total value of the product, minimum insurance cost - 10 euros).</li>
              <li>Customs duties</li>
              <li>Additional payment for delivery to remote areas.</li>
              <li>Additional payment for goods requiring special procedures, such as:</li>
            </ul>
            <div class="grey-card">
              <ul class="grey">
                <li>dangerous goods (Full Dangerous); </li>
                <li>dangerous goods (Consumer Goods ID8000);</li>
                <li>Supplement for lithium batteries: Lithium batteries, Section I, II (PI965, PI966,  PI969);</li>
                <li>Surcharge for address correction;</li>
              </ul>
            </div>
          </template>
          <hr>
          <template v-if="page.blocks.terms">
            <h1 id="terms">{{ page.blocks.terms.name }}</h1>
            <div v-html="page.blocks.terms.content"></div>
          </template>
          <template v-else>
              <h1 id="terms">Delivery Terms</h1>
              <ul>
                <li>Approximate terms of delivery of the ordered goods are specified in the order confirmation. </li>
                <li>These delivery times are not contractual, but are provided for informational purposes only, as they depend, in particular, on the quantity ordered, order modifications accepted, the carrier, the order in which orders are received, the stock status, as well as other unforeseen events such as (but not limited to) a strike , disturbances of any kind, delay in the delivery of raw materials and components necessary for the sale of products or services. In addition, exceeding the delivery time (or even shortage of stock) can never lead to losses, as well as the cancellation of current orders or suspension of order payment, the seller is not responsible in any case for failure to meet the delivery times specified above, which the buyer clearly acknowledges and agrees. </li>
                <li>The order can be completed in one or more deliveries, which does not give the buyer the right to partial payment of the order or service or suspension of the specified payment. </li>
              </ul>
              <br>
              <b><h2>Products shipment - Transfer of risk</h2></b>
              <br>
              <b><p>In case of the absence of product insurance</p></b>
              <br>
              <p>The risks of loss, damage or destruction of the delivered products shall pass to the buyer as soon as the products have been shipped, even partially.</p>
          </template>
          <hr>
          <template v-if="page.blocks.services">
            <h1 id="services">{{ page.blocks.services.name }}</h1>
            <div v-html="page.blocks.services.content"></div>
          </template>
          <template v-else>
            <h1 id="services">Delivery Services</h1>
            <p>When ordering a product, you can choose one of the available courier services:</p>
          </template>
          <div class="services">
            <template v-for="block in blocks">
              <template v-if="block.params">
                <Service v-if="isService(block)" :icon="block.image" :title="block.name" :text="block.content"/>
              </template>
            </template>
          </div>
          <hr>
          <template v-if="page.blocks.tracking">
            <h1 id="tracking">{{ page.blocks.tracking.name }}</h1>
            <div v-html="page.blocks.tracking.content"></div>
          </template>
          <template v-else>
            <h1 id="tracking">Order tracking</h1>
            <p>After the goods are sent to you, you will be sent a tracking number, with the help of which you can track the goods on the carrier’s website.</p>
          </template>
        </div>
      </div>
    </div>
  </section>
</template>

<script>
export default {
  data() {
    return {
        page: {
          name: "About Shipping",
          blocks: {}
        },
        blocks: {}
    }
  },
  mounted() {
    fetch('/api/page/shipping', {
      headers: { 'Content-type': 'application/json' },
      }).then(res=>res.json()).then((response) => {
        this.page = response.data;
        this.page.blocks = {};
        this.getBlocks();
      }).catch((error) => {
        console.log('Error: \n', error);
        return {};
    });
  },
  methods: {
    isService(block)
    {
      return block.params.find((item) => { return item.Param === 'service'}) !== undefined;
    },
    isCountry(block)
    {
      return block.params.find((item) => { return item.Param === 'country'}) !== undefined;
    },
    getParam(array, key) {
        if(array)
        {
          var result = array.find((item) => { return item.Attribute==key });
          if(result.Value)
            return result.Value;
        }

      return null;
    },
    getBlocks() {
      fetch('/api/page/shipping/blocks', {
        headers: { 'Content-type': 'application/json' },
      }).then(res=>res.json()).then((response) => {
        response.data.forEach((item) => {
          if(item.slug)
            this.page.blocks[item.slug] = item;
        });
        this.blocks = response.data;
      }).catch((error) => {
        console.log('Error: \n', error);
        return {};
      });
    }
  }
};
</script>

<style>
h2.shipping-header {
  color: rgb(39, 41, 48);
  font-family: Circe;
  font-size: 38px !important;
  margin-bottom: 2rem !important;
  font-weight: 400;
  line-height: 100%;
  letter-spacing: 0%;
  text-align: left;
}

.help_block {
  margin-top: 2rem;
}

.help_block > h3 {
  color: rgb(40, 51, 74);
  font-family: Circe;
  font-size: 18px;
  font-weight: 400;
  line-height: 100%;
  letter-spacing: 0%;
  text-align: left;
  margin-bottom: 1rem;
}

.help_block > .line {
  width: 28px;
  height: 3px;
  background: rgb(123, 207, 183);
  margin-bottom: 0.5rem;
}

.help_block > .contacts a {
  display: block;
  margin: 1rem 0;
}

.help_block a {
  color: rgb(96, 131, 192);
  font-family: Circe;
  font-size: 16px;
  font-weight: 600;
  line-height: 100%;
  letter-spacing: 0%;
  text-align: left;
  text-decoration-line: underline;
}
.help_block a.big {
  text-decoration-line: none;
  font-size: 26px;
  font-weight: 700;
}

.help_block .button {
  box-sizing: border-box;
  border: 2px solid rgb(244, 244, 245);
  background: rgb(255, 255, 255);
  display: inline-block;
  padding: 1rem 2rem;
  margin-top: 1rem;
}

.help_block .button > a {
  text-decoration-line: none;
}

.heading li::before {
  content: unset;
}

.heading li:hover::before {
  content: '';
  position: absolute;
  width: 43px;
  height: 2px;
  top: 47%;
  right: -62px;
  background: rgb(96, 131, 192);
}

.heading li:hover::after {
  content: '';
  position: absolute;
  width: 30px;
  height: 2px;
  top: 47%;
  box-shadow: 0px 3px 3px rgba(99, 99, 99, 0.5);
  right: -62px;
}

hr {
  margin: 2rem 0;
  height: 1px;
  border-bottom: 1px solid #e8e8e8;
}
.grid {
  display: grid;
  grid-template-columns: 0.7fr 2fr;
  gap: 5rem;
}

.heading {
  position: relative;
  background: rgb(248, 248, 249);
  box-shadow: 0px 3px 3px rgba(99, 99, 99, 0.5);
  padding: 2rem;
  color: rgb(39, 41, 48);
  font-family: Circe;
  font-size: 20px;
  font-weight: 400;
  text-align: left;
  z-index: 2;
}

.heading li {
  line-height: 50px;
  margin-bottom: 0;
  position: relative;
}

.services {
  margin-top: 1.2rem;
  display: grid;
  grid-template-columns: 1fr 1fr 1fr;
  gap: 1rem;
}

.heading a {
  color: rgb(39, 41, 48);
  opacity: 0.4;
}

.heading a:hover {
  color: rgb(96, 131, 192);
  opacity: 1;
}

.content {
  font-family: Circe;
  font-size: 14px;
  font-weight: 400;
  text-align: left;
}

.content h1 {
  font-family: Circe;
  font-size: 36px;
  font-weight: 400;
  line-height: 100%;
  letter-spacing: 0%;
  text-align: left;
  margin-bottom: 1rem;
}

.mb {
  margin-bottom: 3rem;
}
.shipping__wrapper {
  padding-top: 60px;
}
.shipping__wrapper h2 {
  font-size: 26px;
  line-height: 100%;
  margin-bottom: 16px;
}

.shipping__wrapper .banner {
  max-width: 100%;
  margin-bottom: 3rem;
}

.shipping__breadcrumbs {
  margin-bottom: 51px;
}

.shipping { 
  margin-bottom: 3rem;
}

@media (max-width:1024px) {

  h2.shipping-header {
    font-size: 26px !important;
    margin-bottom: 1rem !important;
  }

  .heading {
    display: none;
  }

  .mb {
    margin-bottom: 0;
  }
  .shipping__wrapper {
    padding-top: 36px;
  }

  .shipping__wrapper h1 {
    font-size: 19px;
  }
  .shipping__wrapper h2 {
    font-size: 16px;
    line-height: 100%;
    margin-bottom: 12px;
  }
  .shipping__breadcrumbs {
    margin-bottom: 36px;
  }

  hr {
    margin: 1rem 0;
  }

  .banner {
    margin-bottom: 1rem !important;
  }
}

@media (max-width: 400px) {
  .grid {
    display: flex; 
    flex-direction: column;
  }

  .sidebar {
    order: 2;
  }

  .help_block {
    margin: 0;
  }

  .content {
    order: 1;
  }

  .services {
    grid-template-columns: 1fr;
  }

  .shipping__breadcrumbs {
    margin-bottom: 26px;
  }
}
</style>

<style>
.content ul ul li::before {
  content: '';
  display: inline-block;
  margin-right: 0.5rem;
  width: 4px;
  height: 4px;
  background-color: rgb(123, 207, 183);
  vertical-align: middle;
}

.content ul li::before {
  content: '';
  display: inline-block;
  margin-right: 0.5rem;
  width: 6px;
  height: 6px;
  background-color: #6083c0;
  vertical-align: middle;
}

.content ul li {
  position: relative;
  vertical-align: middle;
  margin-bottom: 16px;
  line-height: 140%;
}

.content ul.grey li::before {
  content: '';
  display: inline-block;
  margin-right: 0.5rem;
  width: 4px;
  height: 4px;
  background-color: rgb(123, 207, 183);
  vertical-align: middle;
}

.grey-card {
  background: rgb(248, 248, 249);
  padding: 1rem;
}
</style>
