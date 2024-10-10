{% if sectionTitle == 'Catering Submissions' %}
    {% include 'emails/brief_catering_template' %}
{% elseif sectionTitle == 'Contact Submissions' %}
    {% include 'emails/brief_contact_template' %}
{% elseif sectionTitle == 'Donation Submissions' %}
    {% include 'emails/brief_donation_template' %}
{% elseif sectionTitle == 'eClub Submissions' %}
    {% include 'emails/brief_eclub_template' %}
{% elseif sectionTitle == 'Hosting Submissions' %}
    {% include 'emails/brief_hosting_template' %}
{% elseif sectionTitle == 'Leasing Submissions' %}
    {% include 'emails/brief_leasing_template' %}
{% elseif sectionTitle == 'NA Submissions' %}
    {% include 'emails/brief_na_template' %}
{% else %}
    {% include 'emails/brief_template' %}
{% endif %}