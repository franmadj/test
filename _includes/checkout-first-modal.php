<div class="event-modal -disabled checkout-first" data-ref="eventModal" data-type="checkout-first">
    <div class="event-modal__innerd">
        <button class="event-modal__exit checkout-first-exit" aria-label="Exit" data-ref="eventModalExitButton"></button>
        <h2 class="event-modal__title">
            You´re headed off-site..
        </h2>
        <h3>Would you like to checkout now?</h3>
        <p>You're switching shops with items in your cart. Our Gift Card products are sold from a seperate shop than our Butcher Shop & Merchandise products and require seperate checkouts.</p>
        <p>If you wish to return to your Gift Card cart, simply navigate back to a Gift Card product page and click the cart icon - if you don't see your products please toggle between our different shopping carts.</p>
        <button type="button" class="action checkout-now">Checkout now</button>

        <button type="button" class="action abandon-now">continue off-site</button>



    </div>
</div>
<script>

    jQuery(document).ready(function ($) {
        $('.checkout-now').click(function () {
            window.location = '/checkout';
        });
        $('.abandon-now').click(function () {
            window.location = $('.checkout-first').data('href');
        });

    });
</script>
<style>
    .checkout-now:after {
        display: inline-block;
        font-size: 4rem;
        content: "\E80C";
        font-family: fontello;
        margin-left: 1.4rem;
        position: relative;
        top: .1rem;
        transform: rotate(
            -90deg
            );
    }
    .checkout-first{
        background-color: rgb(255, 251, 245);
        
        

    }
    .checkout-first > div{
        padding: 5.9rem 4.3rem 3.5rem;
        max-width: 56.3rem;
        background-color: rgb(255, 251, 245);
        color: black;
        border: solid 5px #000;
        margin: 50px auto;
        position: relative;


        font:400 1.6rem/1.4 Futura PT,futura-pt,Helvetica,sans-serif;

    }
    .checkout-first > div .checkout-first-exit{
        color:black;
        width: auto;
        right: 8px;
    top: 8px;
    }
    .checkout-first > div h2{
        color:#86090f;
        margin-bottom: 25px;
        font-weight: bold;
        font-size: 38px;
        letter-spacing: 0px;
        text-transform: inherit;
    }
    .checkout-first > div h3{
        color:#000;
        margin-bottom: 25px;
        font-weight: 700;
        font-size: 39px;
        letter-spacing: 0px;
        text-transform: uppercase;
    }
    .checkout-first > div h2:before {
        content: "\E804";
        font-family: fontello;
        margin-right: 9px;
        color: black;
        font-size: 36px;
    }
    .checkout-first > div p{
        margin-bottom: 30px;
        text-align: left;
        font-size: 22px;
    }
    .checkout-first > div button.action{
        width: 100%;
        padding: 10px;
        color:white;
        margin-bottom: 20px;
        text-align: center;
        font-size: 3.5rem;
        font-weight: bold;
        border: none;
        cursor: pointer;
        text-transform: uppercase;
        font-family: Oswald,Helvetica,sans-serif;
    }
    .checkout-first > div .checkout-now{
        background-color:#86090f; 
    }
    .checkout-first > div .abandon-now{
        background-color:#000; 
    }

    @media (max-width: 400px) {
        .checkout-first{
            padding: 35px 5px 2px 5px;
        }
        .checkout-first > div{
            padding: 0;
            border:none;
            position: static;
            
        }
        .checkout-first > div h3{
            font-size: 18px;
        }
        .checkout-first .event-modal__exit{
            right: 8px;
            top: 8px;
            width: fit-content !important;
            padding: 0;
        }
        .checkout-first > div p{
            margin-bottom: 15px;
           
        }
        .checkout-first > div h2{
            line-height: 32px;
            font-size: 29px;
        }
        .checkout-first > div button.action{
            padding: 4px 10px;
            font-size: 2.5rem;
            margin-bottom: 8px;
            
        }
    }


</style>
<script type="text/javascript">

</script>