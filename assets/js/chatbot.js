const LOCATION_OPTIONS = [
      { label: "", value: "" },
      { label: "Alabama", value: "", disabled: true },
      { label: "Birmingham", value: "Birmingham" },
      { label: "Huntsville", value: "Huntsville" },
      {
        label: "California",
        value: "California",
        disabled: true,
      },
      { label: "Carlsbad", value: "Carlsbad" },
      { label: "Concord", value: "Concord" },
      { label: "Fresno", value: "Fresno" },
      { label: "Irvine", value: "Irvine" },
      { label: "Oxnard", value: "Oxnard" },
      { label: "Rancho Cucamonga", value: "Rancho-Cucamonga" },
      { label: "Colorado", value: "Colorado", disabled: true },
      { label: "Denver", value: "Denver" },
      {
        label: "Connecticut",
        value: "Connecticut",
        disabled: true,
      },
      { label: "Hartford", value: "Hartford" },
      { label: "Florida", value: "Florida", disabled: true },
      { label: "Hallandale Beach", value: "Hallandale-Beach" },
      { label: "Jacksonville", value: "Jacksonville" },
      {
        label: "Miami - Dadeland Mall",
        value: "Dadeland-Mall",
      },
      {
        label: "Miami - Dolphin Mall",
        value: "Dolphin-Mall",
      },
      { label: "Miami Beach", value: "Miami-Beach" },
      { label: "Orlando", value: "Orlando" },
      {
        label: "Palm Beach Gardens",
        value: "Palm-Beach-Gardens",
      },
      { label: "Sunrise", value: "Sunrise" },
      { label: "Tampa", value: "Tampa" },
      { label: "Idaho", value: "Idaho", disabled: true },
      { label: "Boise", value: "Boise" },
      { label: "Illinois", value: "Illinois", disabled: true },
      { label: "Orland Park", value: "orland-park" },
      { label: "Schaumburg", value: "Schaumburg" },
      { label: "Kentucky", value: "Kentucky", disabled: true },
      { label: "Lexington", value: "Lexington" },
      {
        label: "Louisiana",
        value: "Louisiana",
        disabled: true,
      },
      { label: "Baton Rouge", value: "Baton-Rouge" },
      { label: "Michigan", value: "Michigan", disabled: true },
      { label: "Detroit", value: "Detroit" },
      { label: "Nevada", value: "Nevada", disabled: true },
      { label: "Las Vegas", value: "Las-Vegas" },
      { label: "New York", value: "New-York", disabled: true },
      { label: "Albany", value: "Albany" },
      { label: "Buffalo", value: "Buffalo" },
      { label: "Rochester", value: "Rochester" },
      { label: "Long Island", value: "Long-Island" },
      { label: "Syracuse", value: "Syracuse" },
      { label: "Yonkers", value: "Yonkers" },
      { label: "Ohio", value: "Ohio", disabled: true },
      { label: "Columbus", value: "Columbus" },
      { label: "Westlake", value: "Westlake" },
      { label: "Woodmere", value: "Woodmere" },
      { label: "Oklahoma", value: "Oklahoma", disabled: true },
      { label: "Oklahoma City", value: "Oklahoma-City" },
      { label: "Tulsa", value: "Tulsa" },
      {
        label: "Pennsylvania",
        value: "Pennsylvania",
        disabled: true,
      },
      { label: "Pittsburgh", value: "Pittsburgh" },
      {
        label: "Tennessee",
        value: "Tennessee",
        disabled: true,
      },
      { label: "Memphis", value: "Memphis" },
      { label: "Texas", value: "Texas", disabled: true },
      { label: "Addison", value: "Addison" },
      { label: "Dallas", value: "Dallas" },
      { label: "Fort Worth", value: "Fort-Worth" },
      { label: "Houston", value: "Houston" },
      { label: "McAllen", value: "McAllen" },
      { label: "San Antonio", value: "San-Antonio" },
      { label: "Tyler", value: "Tyler" },
      { label: "Virginia", value: "Virginia", disabled: true },
      { label: "Fairfax", value: "Fairfax" },
      { label: "Norfolk", value: "Norfolk" },
      { label: "Richmond", value: "Richmond" },
      {
        label: "Washington",
        value: "Washington",
        disabled: true,
      },
      { label: "Tacoma", value: "Tacoma" },
      {
        label: "Wisconsin",
        value: "Wisconsin",
        disabled: true,
      },
      { label: "Milwaukee", value: "Milwaukee" },
      {
        label: "International",
        value: "international",
        disabled: true,
      },
      { label: "Abu Dhabi", value: "Abu-Dhabi" },
      {
        label: "Dubai Mall, Dubai",
        value: "Dubai-Mall",
      },
      {
        label: "Mall of Qatar, Doha, Qatar",
        value: "Doha-Mall-of-Qatar",
      },
      {
        label: "Mall of the Emirates, Dubai, UAE",
        value: "Mall-of-the-Emirates",
      },
      {
        label: "Palm Beach, Aruba",
        value: "Palm-Beach",
      },
      {
        label: "Panama City, Panama",
        value: "Panama-City",
      },
      {
        label: "Port of Spain, Trinidad and Tobago",
        value: "Port-Of-Spain",
      },
      {
        label: "Riyadh, Saudi Arabia",
        value: "Riyadh",
      },
      {
        label: "San Juan, Puerto Rico",
        value: "San-Juan",
      },
      {
        label: "Santa Fe, México City",
        value: "Mexico-City-Santa-Fe",
      },
      {
        label: "Seoul-Apgujeong, South Korea",
        value: "Seoul-Apgujeong",
      },
      {
        label: "Seoul-Central City, South Korea",
        value: "Seoul-Central-City",
      },
    ];

    const customEncodeURIComponent = (str) => {
      return encodeURIComponent(str).replace(/[!'()*~_ ]/g, (c) => {
        return `%${c.charCodeAt(0).toString(16)}`;
      });
    };

    window.HFBOT_CONFIG = {
      EMBED_TOKEN: "15de7113-14ce-4b36-8cb8-07e542cf5afb",
      options: {
        showBadge: true,
      },
      onLoad: function (sdk) {
        window.sdk = sdk;
        sdk.addCustomStyles(
          ".avatar img {display: none} .avatar {background-image: url(https://cdn.glitch.global/9fb84795-1408-4f41-b475-e9a581f4f998/white%20logo.png?v=1651728408139);background-color: rgb(76 42 231);border-radius:50%; background-repeat: no-repeat;background-position: center; background-size: contain} .text-input { font-size: 16px; }"
        );
      },
      overrideEvent: function (sdk, event) {
        console.log("logging override", event);
        if (
          event.type === "BotQuickReplies" &&
          event.data.choices[0].text.includes("FORM 1")
        ) {
          return {
            ...event,
            type: "BotForm",
            data: {
              name: `guest-feedback-form`,
              fields: [
                {
                  type: "input_text",
                  name: "name",
                  label: "Name",
                  validations: {
                    required: {
                      value: true,
                      message: "This field is required",
                    },
                  },
                  linkedTo: "visitor.name",
                },
                {
                  type: "input_text",
                  name: "email",
                  label: "Email",
                  validations: {
                    required: {
                      value: true,
                      message: "This field is required",
                    },
                    email: {
                      value: true,
                      message: "Please enter a valid email",
                    },
                  },
                  linkedTo: "visitor.email",
                },
                {
                  type: "input_text",
                  name: "date_visited",
                  label: "Date visited",
                  placeholder: "MM-DD-YYYY",
                  validations: {
                    required: {
                      value: true,
                      message: "This field is required",
                    },
                    pattern: {
                      value:
                        "^([0]?[1-9]|[1][0-2])[./-]([0]?[1-9]|[1|2][0-9]|[3][0|1])[./-]([0-9]{4}|[0-9]{2})$",
                      message: "Please enter a date in the format MM-DD-YYYY",
                    },
                  },
                },
                {
                  type: "dropdown",
                  name: "location_visited",
                  label: "Location visited",
                  placeholder: "Select a location",
                  options: LOCATION_OPTIONS,
                  validations: {
                    required: {
                      value: true,
                      message: "This field is required",
                    },
                  },
                },
                {
                  type: "input_text",
                  name: "check_number",
                  label: "Check number (Optional)",
                },
                {
                  type: "textarea",
                  name: "comments",
                  label: "Comments",
                  validations: {
                    required: {
                      value: true,
                      message: "This field is required",
                    },
                  },
                },
                {
                  type: "button",
                  label: "Submit",
                  style: "primary",
                  action: {
                    type: "submit",
                  },
                },
              ],
            },
          };
        }

        if (
          event.type === "BotQuickReplies" &&
          event.data.choices[0].text.includes("FORM 2")
        ) {
          return {
            ...event,
            type: "BotForm",
            data: {
              name: `find-location-form`,
              fields: [
                {
                  type: "dropdown",
                  name: "locations",
                  label: "Locations",
                  placeholder: "Select a location",
                  defaultValue: { label: "Select a value", value: " " },
                  options: LOCATION_OPTIONS,
                  validations: {
                    required: {
                      value: true,
                      message: "This field is required",
                    },
                  },
                },
                {
                  type: "button",
                  label: "Submit",
                  style: "primary",
                  action: {
                    type: "submit",
                  },
                },
              ],
            },
          };
        }

        if (
          event.type === "BotQuickReplies" &&
          event.data.choices[0].text.includes("FORM 3")
        ) {
          return {
            ...event,
            type: "BotForm",
            data: {
              name: `online-order-form`,
              fields: [
                {
                  type: "input_text",
                  name: "name",
                  label: "Name",
                  validations: {
                    required: {
                      value: true,
                      message: "This field is required",
                    },
                  },
                  linkedTo: "visitor.name",
                },
                {
                  type: "input_text",
                  name: "email",
                  label: "Billing Email",
                  validations: {
                    required: {
                      value: true,
                      message: "This field is required",
                    },
                    email: {
                      value: true,
                      message: "Please enter a valid email",
                    },
                  },
                  linkedTo: "visitor.email",
                },
                {
                  type: "input_text",
                  name: "order_number",
                  label: "Order number",
                },
                {
                  type: "textarea",
                  name: "comments",
                  label: "Comments",
                  validations: {
                    required: {
                      value: true,
                      message: "This field is required",
                    },
                    maxLength: {
                      value: 1500,
                      message: "Please enter less than 1500 characters",
                    },
                  },
                },
                {
                  type: "button",
                  label: "Submit",
                  style: "primary",
                  action: {
                    type: "submit",
                  },
                },
              ],
            },
          };
        }

        if (
          event.type === "BotQuickReplies" &&
          event.data.choices[0].text.includes("FORM 4")
        ) {
          return {
            ...event,
            type: "BotForm",
            data: {
              name: `question-form`,
              fields: [
                {
                  type: "input_text",
                  name: "name",
                  label: "Name",
                  validations: {
                    required: {
                      value: true,
                      message: "This field is required",
                    },
                  },
                  linkedTo: "visitor.name",
                },
                {
                  type: "input_text",
                  name: "email",
                  label: "Email",
                  validations: {
                    required: {
                      value: true,
                      message: "This field is required",
                    },
                    email: {
                      value: true,
                      message: "Please enter a valid email",
                    },
                  },
                  linkedTo: "visitor.email",
                },
                {
                  type: "textarea",
                  name: "question",
                  label: "Question",
                  validations: {
                    required: {
                      value: true,
                      message: "This field is required",
                    },
                  },
                },
                {
                  type: "button",
                  label: "Submit",
                  style: "primary",
                  action: {
                    type: "submit",
                  },
                },
              ],
            },
          };
        }
      },
      onSubmit: async function (sdk, event) {
        if (event.form_name === "guest-feedback-form") {
          const dateVisitedKey = customEncodeURIComponent("date_visited");
          const locationVisitedKey =
            customEncodeURIComponent("location_visited");
          const checkNumberKey = customEncodeURIComponent("check_number");
          await sdk.sendBotMessages([
            {
              type: "BotMessage",
              event_id: event.reply_for,
              data: {
                text: `Name: ${event.values.name}
 Email: ${event.values.email}
 Date Visited: ${event.values[dateVisitedKey]}
 Location Visited: ${event.values[locationVisitedKey]}
 Check number: ${event.values[checkNumberKey]}
 Comments:
 ${event.values.comments}`,
              },
            },
          ]);
          await sdk.goToStep({ stepName: "feedback-sent" });
        }

        if (event.form_name === "online-order-form") {
          const orderNumberKey = customEncodeURIComponent("order_number");
          await sdk.sendBotMessages([
            {
              type: "BotMessage",
              event_id: event.reply_for,
              data: {
                text: `Name: ${event.values.name}
 Biling Email: ${event.values.email}
 Order number: ${event.values[orderNumberKey]}
 Comments:
 ${event.values.comments}`,
              },
            },
          ]);
          await sdk.goToStep({ stepName: "inquiry-sent" });
        }

        if (event.form_name === "question-form") {
          await sdk.sendBotMessages([
            {
              type: "BotMessage",
              event_id: event.reply_for,
              data: {
                text: `Name: ${event.values.name}
 Email: ${event.values.email}
 Question:
 ${event.values.question}`,
              },
            },
          ]);
          await sdk.goToStep({ stepName: "question-sent" });
        }

        if (event.form_name === "find-location-form") {
          console.log("find-location-form", event);

          await sdk.sendBotMessages([
            {
              type: "BotMessage",
              event_id: event.reply_for,
              components: [
                {
                  type: "text",
                  text: "Click on the button below to view that location's pricing, hours, and additional information.",
                },
                {
                  type: "spacer",
                  size: "s",
                },
                {
                  type: "button",
                  style: "primary",
                  label: `${event.values.locations} Location Page`,
                  action: {
                    type: "link",
                    url: `https://texasdebrazil.com/locations/${event.values.locations}/`,
                  },
                },
              ],
            },
          ]);
          await sdk.goToStep({ stepName: "what-would-you-like-to-do-next" });
        }

        if (event.values?.name) {
          sdk.setVisitorProperties({
            name: event.values.name,
          });
        }

        if (event.values?.email) {
          sdk.setVisitorProperties({
            email: event.values.email,
          });
        }
      },
    };

    window.HFBOT_CONFIG.onConversationWindowOpen = async (sdk) => {
      var styles = "#__HAPPYFOX_WIDGET_BADGE__::before { display: none; }";

      var css = document.createElement("style");
      css.type = "text/css";

      if (css.styleSheet) css.styleSheet.cssText = styles;
      else css.appendChild(document.createTextNode(styles));

      document.getElementById("__HAPPYFOX_WIDGET_BADGE__").appendChild(css);
    };

    window.HFBOT_CONFIG.onConversationWindowClose = async (sdk) => {
      var styles = "#__HAPPYFOX_WIDGET_BADGE__::before { display: block; }";

      var css = document.createElement("style");
      css.type = "text/css";

      if (css.styleSheet) css.styleSheet.cssText = styles;
      else css.appendChild(document.createTextNode(styles));

      document.getElementById("__HAPPYFOX_WIDGET_BADGE__").appendChild(css);
    };

    (function () {
      const scriptTag = document.createElement("script");
      scriptTag.type = "text/javascript";
      scriptTag.async = true;
      scriptTag.defer = true;
      scriptTag.src = "https://bot-widget.happyfox.com/js/widget-loader.js";
      var e = document.body || document.head;
      e.appendChild(scriptTag);
    })();