<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="apple-touch-icon" type="image/png" href="https://static.codepen.io/assets/favicon/apple-touch-icon-5ae1a0698dcc2402e9712f7d01ed509a57814f994c660df9f7a952f3060705ee.png" />
    <meta name="apple-mobile-web-app-title" content="CodePen">
    <link rel="shortcut icon" type="image/x-icon" href="https://static.codepen.io/assets/favicon/favicon-aec34940fbc1a6e787974dcd360f2c6b63348d4b1f4e06c77743096d55480f33.ico" />
    <link rel="mask-icon" type="" href="https://static.codepen.io/assets/favicon/logo-pin-8f3771b1072e3c38bd662872f6b673a722f4b3ca2421637d5596661b4e2132cc.svg" color="#111" />
    <title>CodePen - VueJS 2 Simple Shopping cart</title>
    <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/css/bootstrap.min.css'>
    <style>
        .container{
            padding:20px;
            max-width:600px;
        }

        .input-qty {
            width: 60px;
            float: right
        }

        .table-cart > tr > td {
            vertical-align: middle !important;
        }
    </style>
    <script>
        window.console = window.console || function(t) {};
    </script>
    <script>
        if (document.location.search.match(/type=embed/gi)) {
            window.parent.postMessage("resize", "*");
        }
    </script>
</head>
<body translate="no">
<div id="app" class="container">
    <div class="text-right"><button class="btn btn-primary" data-toggle="modal" data-target="#cartModal">Cart ({{cartItems.length}})</button></div>

    <div class="modal fade" id="cartModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">Cart</h4>
                </div>
                <div class="modal-body">
                    <shopping-cart inline-template :items="cartItems">
                        <div>
                            <table class="table table-cart">
                                <tr v-for="(item, index) in items">
                                    <td>{{item.title}}</td>
                                    <td style="width:120px">QTY:
                                        <input v-model="item.qty" class="form-control input-qty" type="number">
                                    </td>
                                    <td class="text-right">${{item.price | formatCurrency}}</td>
                                    <td>
                                        <button @click="removeItem(index)"><span class="glyphicon glyphicon-trash"></span></button>
                                    </td>
                                </tr>
                                <tr v-show="items.length === 0">
                                    <td colspan="4" class="text-center">Cart is empty</td>
                                </tr>
                                <tr v-show="items.length > 0">
                                    <td></td>
                                    <td class="text-right">Cart Total</td>
                                    <td class="text-right">${{Total | formatCurrency}}</td>
                                    <td></td>
                                </tr>
                            </table>
                        </div>

                    </shopping-cart>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="row">
            <div class="col-xs-3 text-center" v-for="item in items">
                <img class="img-responsive" :src="item.image" alt="">
                <h5>{{ item.title }}</h5>
                <h6>${{ item.price | formatCurrency }}</h6>
                <p class="text-center"><input v-model="item.qty" type="number" class="form-control" placeholder="Qty" min="1" /></p>
                <button @click="addToCart(item)" class="btn btn-sm btn-primary">Add to Cart</button>
                </p>
            </div>
        </div>
    </div>
</div>
<script src="https://static.codepen.io/assets/common/stopExecutionOnTimeout-157cd5b220a5c80d4ff8e0e70ac069bffd87a61252088146915e8726e5d9f147.js"></script>
<script src='https://cdnjs.cloudflare.com/ajax/libs/vue/2.1.10/vue.min.js'></script>
<script src='https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.1/jquery.min.js'></script>
<script src='https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/js/bootstrap.min.js'></script>
<script id="rendered-js">
    const products = [
        { id: 1, title: 'Macbook Pro', price: 2500.00, qty: 1, image: 'http://lorempixel.com/150/150/' },
        { id: 2, title: 'Asus ROG Gaming', price: 1000.00, qty: 1, image: 'http://lorempixel.com/150/150/' },
        { id: 3, title: 'Amazon Kindle', price: 150.00, qty: 1, image: 'http://lorempixel.com/150/150/' },
        { id: 4, title: 'Another Product', price: 10, qty: 1, image: 'http://lorempixel.com/150/150/' }];


    function formatNumber(n, c, d, t) {
        var c = isNaN(c = Math.abs(c)) ? 2 : c,
            d = d === undefined ? '.' : d,
            t = t === undefined ? ',' : t,
            s = n < 0 ? '-' : '',
            i = String(parseInt(n = Math.abs(Number(n) || 0).toFixed(c))),
            j = (j = i.length) > 3 ? j % 3 : 0;
        return s + (j ? i.substr(0, j) + t : '') + i.substr(j).replace(/(\d{3})(?=\d)/g, '$1' + t) + (c ? d + Math.abs(n - i).toFixed(c).slice(2) : '');
    };

    // Allow the formatNumber function to be used as a filter
    Vue.filter('formatCurrency', function (value) {
        return formatNumber(value, 2, '.', ',');
    });

    // The shopping cart component
    Vue.component('shopping-cart', {
        props: [
            'items'
        ],

        computed: {
            Total() {
                let total = 0;
                this.items.forEach(item => {
                    total += item.price * item.qty;
                });
                return total;
            } },


        methods: {
            // Remove item by its index
            removeItem(index) {
                this.items.splice(index, 1);
            } } });



    const vm = new Vue({
        el: '#app',

        data: {
            cartItems: [],
            items: products },


        methods: {
            // Add Items to cart
            addToCart(itemToAdd) {
                let found = false;

                // Add the item or increase qty
                let itemInCart = this.cartItems.filter(item => item.id === itemToAdd.id);
                let isItemInCart = itemInCart.length > 0;

                if (isItemInCart === false) {
                    this.cartItems.push(Vue.util.extend({}, itemToAdd));
                } else {
                    itemInCart[0].qty += itemToAdd.qty;
                }

                itemToAdd.qty = 1;
            } } });
    //# sourceURL=pen.js
</script>
</body>
</html>
