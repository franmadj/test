{% import '_components/macros' as createComponent %}

{% set data = craft.geo.info(true) %}

{% set slug = craft.request.getSegment(2) %}

{% if slug %}
    {% set locationEntry = craft.entries.section('locations').slug(slug) %}
{% endif %}

<form method="GET" action="https://secure.opentable.com/ism/interim.aspx" class="table-finder" data-ref="tablePopupForm" target="_blank" id="reserveTable">
    <input type="hidden" name="ot_submit" value="Book a Table">
    <input type="hidden" name="txtDateFormat" value="MM/dd/yyyy">

    <div class="table-finder__field -location">
        <label for="table-location" class="table-finder__label">Choose location</label>
        <div class="table-finder__dropdown">
            <select name="RestaurantID" id="resturant-select" class="table-finder__select" data-ref="selectedLocationPopup" required>
              <option value="" disabled selected>Select a Location</option>

                {# <option selected>Choose a location</option> #}

                {# {% set entriesByState = craft.entries.location().order('title asc') %}

                {% set entries = entriesByState | supersort('sortAs', '{location.parts.administrative_area_level_1}') %} #}

                {% set entriesByDistance = craft.entries.location({
                    location: {
                        lat: data.latitude,
                        lng: data.longitude
                    },
                    radius: 9999,
                    unit: 'mi',
                }).order('distance').limit(1) %}

                {% set entriesByState = craft.entries.location({
                    location: {
                        lat: data.latitude,
                        lng: data.longitude
                    },
                    radius: 999999,
                    unit: 'mi',
                }).order('') %}

                {% set entriesByState = entriesByState | supersort('sortAs', '{location.parts.administrative_area_level_1}') %}

                {% set entries = entriesByDistance|merge(entriesByState) %}

                {% for entry in entries %}
                    {% if entry.restaurantId %}
                        {% set address = entry.location.parts %}
                        <option
                            value="{{ entry.title }}-{{ entry.restaurantId }}"
                            class="table-finder__option"
                            {% if entry.slug == slug %} selected{% endif %}
                        >
                            {{ entry.title }}
                            {%- if entry.type == 'international' -%}
                                , {{ entry.location.parts.country }}
                            {%- elseif address.administrative_area_level_1 -%}
                                , {{ address.administrative_area_level_1 }}
                            {%- elseif entry.state | length -%}
                                , {{ entry.state }}
                            {%- endif -%}
                        </option>
                    {% endif %}
                {% endfor %}
            </select>
        </div>
    </div>

    <div class="table-finder__field -date">
        <label for="table-date" class="table-finder__label">Pick a date</label>
        <div class="table-finder__dropdown">
            <input type="text" name="startDate" class="datepicker tableFinderDate" data-el="tableFinderDate" placeholder="Pick a Date" value="" aria-label="Date" readonly>
        </div>
    </div>

    <div class="table-finder__field -time">
        <label for="table-time" class="table-finder__label">Pick a time</label>
        <div class="table-finder__dropdown">
            <select name="resTime" class="table-finder__select tableFinderTime" data-el="tableFinderTime" >
                {% for i in 11..12 %}
                <option value="{{ i }}:00 {% if i == '12' %}PM{% else %}AM{% endif %}" data-hour="{{ i }}00" class="table-finder__option">{{ i }}:00{% if i == '12' %}pm{% else %}am{% endif %}</option>
                <option value="{{ i }}:30 {% if i == '12' %}PM{% else %}AM{% endif %}" data-hour="{{ i }}30" class="table-finder__option">{{ i }}:30{% if i == '12' %}pm{% else %}am{% endif %}</option>
                {% endfor %}

                {% for i in 1..11 %}
                <option value="{{ i }}:00 PM" data-hour="{{ i+12 }}00" class="table-finder__option">{{ i }}:00pm</option>
                <option value="{{ i }}:30 PM" data-hour="{{ i+12 }}30" class="table-finder__option">{{ i }}:30pm</option>
                {% endfor %}
            </select>
        </div>
    </div>

    <div class="table-finder__field -guests">
        <label for="table-guests" class="table-finder__label">Guests</label>
        <div class="table-finder__dropdown">
            <select name="partySize" class="table-finder__select">
                {% for i in 1..14 %}
                    <option{% if loop.index == 2 %} selected{% endif %} class="table-finder__option">{{ i }}</option>
                {% endfor %}
                    <option value="15+" class="table-finder__option">15+</option>
            </select>
        </div>
    </div>

    <button class="table-finder__submit" type="submit">
        Find a table

        {{ createComponent.bottomBorder({
            class: 'table-finder__submit-border'
        }) }}
    </button>
</form>
<script type="text/javascript">
    //$(function() {
    //});

</script>
