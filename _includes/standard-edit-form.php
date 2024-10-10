<form method="POST" data-ref="editForm" class="u-edit-form">
    <input type="hidden" name="action" value="commerce/cart/updateLineItem">
    <input type="hidden" name="lineItemId" value="{{ item.id }}">
    {% nocache %}{{ getCsrfInput() }}{% endnocache %}

    <div class="u-flex-container">
        <div class="c-edit-option">
            <span class="c-edit-option__label">Amount</span>
            <select name="purchasableId">
                {% for variant in product.product.variants %}
                    <option value="{{ variant.purchasableId }}">{{ variant.salePrice|currency(cart.currency, true) }}</option>
                {% endfor %}
            </select>
        </div>
        <div class="c-edit-option">
            <span class="c-edit-option__label">Qty</span>
            <input type="number" name="qty" value="{{ item.qty }}">
        </div>
    </div>

    <div class="c-edit-option c-edit-option--full">
        <div class="u-flex-container">
            <div class="c-edit-option c-edit-option--full t-align-right">
                <button class="button c-edit-option__save">Save</button>
            </div>
        </div>
    </div>
</form>
