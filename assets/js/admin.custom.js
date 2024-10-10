jQuery(document).ready(function ($) {
    if ($('#order_line_items .item').length) {
        $('#order_line_items .item').each(function () {
            const $item=$(this);


            const isGiftCard = $item.find("th:contains('isGiftCard:')");
            if (isGiftCard.length && $('.post-type-shop_order').length) {
                const element_1 = $item.find("th:contains('user_email:')")
                const element_2 = $item.find("th:contains('User email:')")
                const element = element_1.length ? element_1 : element_2;
                const parent_element = element.parent();
                const link = element.next().find('a');
                const email = link.text();
                link.after(` <span class="edit-gift-email" style="cursor:pointer;"><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" fill="#000000" version="1.1" id="Capa_1" width="15px" height="15px" viewBox="0 0 528.899 528.899" xml:space="preserve">
<g><path d="M328.883,89.125l107.59,107.589l-272.34,272.34L56.604,361.465L328.883,89.125z M518.113,63.177l-47.981-47.981   c-18.543-18.543-48.653-18.543-67.259,0l-45.961,45.961l107.59,107.59l53.611-53.611   C532.495,100.753,532.495,77.559,518.113,63.177z M0.3,512.69c-1.958,8.812,5.998,16.708,14.811,14.565l119.891-29.069   L27.473,390.597L0.3,512.69z"/></g>
</svg></span>`)
                parent_element.after(`<tr style="display:none;"><th>edit email:</th><td style="display:flex;gap:3px;width:300px;"><input class="gift-email" style="padding:0 3px;border:solid thin;" type="text" value="${email}"><button class="update-gift-email" type="button">Update</button></td></tr>`)
                console.log('element', element)

                $item.find('.edit-gift-email').click(function (e) {
                    e.preventDefault()
                    parent_element.hide();
                    parent_element.next().show();

                })

                $item.find('.update-gift-email').click(function (e) {
                    let item_name = $(this).closest('.name').find('.wc-order-item-name').text()
                    const item_id = $(this).closest('.name').find('.order_item_id').val()
                    const email = $item.find('.gift-email').val();
                    var validRegex = /^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-]+@[a-zA-Z0-9-]+(?:\.[a-zA-Z0-9-]+)*$/;

                    if (!email.match(validRegex))
                        return;

                    $.ajax({
                        type: "post",
                        url: '/wp-admin/admin-ajax.php',
                        data: {
                            action: "update_gift_email",
                            email: email,
                            item_id: item_id,
                            item_name,
                            post_id: $('#post_ID').val()
                        },
                        error: function (response) {

                        },
                        success: function (response) {
                            $item.find("th:contains('edit email:')").parent().hide();
                            const element_orig = $item.find("th:contains('User email:')")
                            element_orig.next().find('a').attr('href', 'mailto:' + email).text(email);
                            element_orig.parent().show();
                            $item.find('input[value="user_email').next().text(email).val(email)


                        }
                    })


                })

            }
            
            
        })
    }

});


