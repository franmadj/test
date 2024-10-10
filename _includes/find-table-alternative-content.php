<div class="event-modal -disabled find_table_text">
    <div class="event-modal__inner">
        <button class="event-modal__exit find_table_text_exit" aria-label="Exit" data-ref="eventModalExitButton"></button>
        <h2 class="event-modal__title">
            Find a Table
        </h2>
        <?php the_field('find_table_alternative_content_modal'); ?>



    </div>
</div>
<style>

    .find_table_text{
        background-color: rgb(255, 251, 245);



    }
    .find_table_text > div{
        padding: 5.9rem 4.3rem 3.5rem;
        max-width: 56.3rem;
        background-color: rgb(255, 251, 245);
        color: black;
        border: solid 5px #000;
        margin: 50px auto;
        position: relative;


        font:400 1.6rem/1.4 Futura PT,futura-pt,Helvetica,sans-serif;

    }
    .find_table_text > div .find_table_text_exit{
        color:black;
        width: auto;
        right: 8px;
        top: 8px;
    }
    .find_table_text > div h2{
        color:#86090f;
        margin-bottom: 25px;
        font-weight: bold;
        font-size: 38px;
        letter-spacing: 0px;
        text-transform: inherit;
    }
    .find_table_text > div h3{
        color:#000;
        margin-bottom: 25px;
        font-weight: 700;
        font-size: 39px;
        letter-spacing: 0px;
        text-transform: uppercase;
    }

    .find_table_text > div p{
        margin-bottom: 30px;
        text-align: left;
        font-size: 22px;
    }
    .find_table_text > div button.action{
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


    @media (max-width: 400px) {
        .find_table_text{
            padding: 35px 5px 2px 5px;
        }
        .find_table_text > div{
            padding: 0;
            border:none;
            position: static;

        }
        .find_table_text > div h3{
            font-size: 18px;
        }
        .find_table_text .event-modal__exit{
            right: 8px;
            top: 8px;
            width: fit-content !important;
            padding: 0;
        }
        .find_table_text > div p{
            margin-bottom: 15px;

        }
        .find_table_text > div h2{
            line-height: 32px;
            font-size: 29px;
        }
        .find_table_text > div button.action{
            padding: 4px 10px;
            font-size: 2.5rem;
            margin-bottom: 8px;

        }
    }


</style>

