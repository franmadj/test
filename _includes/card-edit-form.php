<form method="POST" data-ref="editForm" class="u-edit-form">
    <input type="hidden" name="action" value="commerce/cart/updateLineItem">
    <input type="hidden" name="lineItemId" value="{{ item.id }}">
    {% nocache %}{{ getCsrfInput() }}{% endnocache %}

    <div class="u-flex-container">
        <div class="c-edit-option">
            <span class="c-edit-option__label">Amount</span>
            <select name="options[amount]">
                {% for row in item.purchasable.product.denominations %}
                    <option value="{{ row.col1 }}"{% if item.options.amount == row.col1 %} selected{% endif %}>${{ row.col1 }}</option>
                {% endfor %}
            </select>
        </div>
        <div class="c-edit-option">
            <span class="c-edit-option__label">Qty</span>
            <input type="number" name="qty" value="{{ item.qty }}">
        </div>
    </div>

    {% if item.purchasable.product.slug != 'standard-card' %}
        <div class="c-edit-option c-edit-option--full">
            <span class="c-edit-option__label">Options</span>
            <div class="u-flex-container">
                    <input type="hidden" name="options[themeId]" value="{{ options.themeId }}">

                    <div class="c-edit-option c-edit-option--full">
                        <input type="text" name="options[email]" value="{{ options.email }}" placeholder="Email">
                    </div>
                    <div class="c-edit-option">
                        <input type="text" name="options[firstName]" value="{{ options.firstName }}" placeholder="First Name">
                    </div>
                    <div class="c-edit-option">
                        <input type="text" name="options[lastName]" value="{{ options.lastName }}" placeholder="Last Name">
                    </div>
                <div class="c-edit-option c-edit-option--full t-align-right">
                    <button class="button c-edit-option__save">Save</button>
                </div>
            </div>
        </div>
    {% else %}
        <div class="c-edit-option c-edit-option--full t-align-right">
            <button class="button c-edit-option__save">Save</button>
        </div>
    {% endif %}
</form>
