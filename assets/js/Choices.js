/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
!function (e, t) {
    "object" == typeof exports && "object" == typeof module ? module.exports = t() : "function" == typeof define && define.amd ? define([], t) : "object" == typeof exports ? exports.Choices = t() : e.Choices = t()
}(this, function () {
    return function (e) {
        function t(n) {
            if (i[n])
                return i[n].exports;
            var s = i[n] = {exports: {}, id: n, loaded: !1};
            return e[n].call(s.exports, s, s.exports, t), s.loaded = !0, s.exports
        }
        var i = {};
        return t.m = e, t.c = i, t.p = "/assets/scripts/dist/", t(0)
    }([function (e, t, i) {
            e.exports = i(1)
        }, function (e, t, i) {
            "use strict";
            function n(e) {
                return e && e.__esModule ? e : {default: e}
            }
            function s(e, t, i) {
                return t in e ? Object.defineProperty(e, t, {value: i, enumerable: !0, configurable: !0, writable: !0}) : e[t] = i, e
            }
            function o(e) {
                if (Array.isArray(e)) {
                    for (var t = 0, i = Array(e.length); t < e.length; t++)
                        i[t] = e[t];
                    return i
                }
                return Array.from(e)
            }
            function r(e, t) {
                if (!(e instanceof t))
                    throw new TypeError("Cannot call a class as a function")
            }
            var a = function () {
                function e(e, t) {
                    for (var i = 0; i < t.length; i++) {
                        var n = t[i];
                        n.enumerable = n.enumerable || !1, n.configurable = !0, "value"in n && (n.writable = !0), Object.defineProperty(e, n.key, n)
                    }
                }
                return function (t, i, n) {
                    return i && e(t.prototype, i), n && e(t, n), t
                }
            }(), c = i(2), l = n(c), u = i(3), h = n(u), d = i(4), f = n(d), p = i(30), v = i(31);
            i(32);
            var m = function () {
                function e() {
                    var t = arguments.length > 0 && void 0 !== arguments[0] ? arguments[0] : "[data-choice]", i = arguments.length > 1 && void 0 !== arguments[1] ? arguments[1] : {};
                    if (r(this, e), (0, v.isType)("String", t)) {
                        var n = document.querySelectorAll(t);
                        if (n.length > 1)
                            for (var s = 1; s < n.length; s++) {
                                var o = n[s];
                                new e(o, i)
                            }
                    }
                    var a = {silent: !1, items: [], choices: [], maxItemCount: -1, addItems: !0, removeItems: !0, removeItemButton: !1, editItems: !1, duplicateItems: !0, delimiter: ",", paste: !0, searchEnabled: !0, searchChoices: !0, searchFloor: 1, searchResultLimit: 4, searchFields: ["label", "value"], position: "auto", resetScrollPosition: !0, regexFilter: null, shouldSort: !0, shouldSortItems: !1, sortFilter: v.sortByAlpha, placeholder: !0, placeholderValue: null, prependValue: null, appendValue: null, renderSelectedChoices: "auto", loadingText: "Loading...", noResultsText: "No results found", noChoicesText: "No choices to choose from", itemSelectText: "Press to select", addItemText: function (e) {
                            return'Press Enter to add <b>"' + e + '"</b>'
                        }, maxItemText: function (e) {
                            return"Only " + e + " values can be added."
                        }, uniqueItemText: "Only unique values can be added.", classNames: {containerOuter: "choices", containerInner: "choices__inner", input: "choices__input", inputCloned: "choices__input--cloned", list: "choices__list", listItems: "choices__list--multiple", listSingle: "choices__list--single", listDropdown: "choices__list--dropdown", item: "choices__item", itemSelectable: "choices__item--selectable", itemDisabled: "choices__item--disabled", itemChoice: "choices__item--choice", placeholder: "choices__placeholder", group: "choices__group", groupHeading: "choices__heading", button: "choices__button", activeState: "is-active", focusState: "is-focused", openState: "is-open", disabledState: "is-disabled", highlightedState: "is-highlighted", hiddenState: "is-hidden", flippedState: "is-flipped", loadingState: "is-loading"}, fuseOptions: {include: "score"}, callbackOnInit: null, callbackOnCreateTemplates: null};
                    if (this.idNames = {itemChoice: "item-choice"}, this.config = (0, v.extend)(a, i), "auto" !== this.config.renderSelectedChoices && "always" !== this.config.renderSelectedChoices && (this.config.silent || console.warn("renderSelectedChoices: Possible values are 'auto' and 'always'. Falling back to 'auto'."), this.config.renderSelectedChoices = "auto"), this.store = new f.default(this.render), this.initialised = !1, this.currentState = {}, this.prevState = {}, this.currentValue = "", this.element = t, this.passedElement = (0, v.isType)("String", t) ? document.querySelector(t) : t, this.isTextElement = "text" === this.passedElement.type, this.isSelectOneElement = "select-one" === this.passedElement.type, this.isSelectMultipleElement = "select-multiple" === this.passedElement.type, this.isSelectElement = this.isSelectOneElement || this.isSelectMultipleElement, this.isValidElementType = this.isTextElement || this.isSelectElement, !this.passedElement)
                        return void(this.config.silent || console.error("Passed element not found"));
                    this.config.shouldSortItems === !0 && this.isSelectOneElement && (this.config.silent || console.warn("shouldSortElements: Type of passed element is 'select-one', falling back to false.")), this.highlightPosition = 0, this.canSearch = this.config.searchEnabled, this.presetChoices = this.config.choices, this.presetItems = this.config.items, this.passedElement.value && (this.presetItems = this.presetItems.concat(this.passedElement.value.split(this.config.delimiter))), this.baseId = (0, v.generateId)(this.passedElement, "choices-"), this.render = this.render.bind(this), this._onFocus = this._onFocus.bind(this), this._onBlur = this._onBlur.bind(this), this._onKeyUp = this._onKeyUp.bind(this), this._onKeyDown = this._onKeyDown.bind(this), this._onClick = this._onClick.bind(this), this._onTouchMove = this._onTouchMove.bind(this), this._onTouchEnd = this._onTouchEnd.bind(this), this._onMouseDown = this._onMouseDown.bind(this), this._onMouseOver = this._onMouseOver.bind(this), this._onPaste = this._onPaste.bind(this), this._onInput = this._onInput.bind(this), this.wasTap = !0;
                    var c = "classList"in document.documentElement;
                    c || this.config.silent || console.error("Choices: Your browser doesn't support Choices");
                    var l = (0, v.isElement)(this.passedElement) && this.isValidElementType;
                    if (l) {
                        if ("active" === this.passedElement.getAttribute("data-choice"))
                            return;
                        this.init()
                    } else
                        this.config.silent || console.error("Incompatible input passed")
                }
                return a(e, [{key: "init", value: function () {
                            if (this.initialised !== !0) {
                                var e = this.config.callbackOnInit;
                                this.initialised = !0, this._createTemplates(), this._createInput(), this.store.subscribe(this.render), this.render(), this._addEventListeners(), e && (0, v.isType)("Function", e) && e.call(this)
                            }
                        }}, {key: "destroy", value: function () {
                            if (this.initialised !== !1) {
                                this._removeEventListeners(), this.passedElement.classList.remove(this.config.classNames.input, this.config.classNames.hiddenState), this.passedElement.removeAttribute("tabindex");
                                var e = this.passedElement.getAttribute("data-choice-orig-style");
                                Boolean(e) ? (this.passedElement.removeAttribute("data-choice-orig-style"), this.passedElement.setAttribute("style", e)) : this.passedElement.removeAttribute("style"), this.passedElement.removeAttribute("aria-hidden"), this.passedElement.removeAttribute("data-choice"), this.passedElement.value = this.passedElement.value, this.containerOuter.parentNode.insertBefore(this.passedElement, this.containerOuter), this.containerOuter.parentNode.removeChild(this.containerOuter), this.clearStore(), this.config.templates = null, this.initialised = !1
                            }
                        }}, {key: "renderGroups", value: function (e, t, i) {
                            var n = this, s = i || document.createDocumentFragment(), o = this.config.sortFilter;
                            return this.config.shouldSort && e.sort(o), e.forEach(function (e) {
                                var i = t.filter(function (t) {
                                    return n.isSelectOneElement ? t.groupId === e.id : t.groupId === e.id && !t.selected
                                });
                                if (i.length >= 1) {
                                    var o = n._getTemplate("choiceGroup", e);
                                    s.appendChild(o), n.renderChoices(i, s)
                                }
                            }), s
                        }}, {key: "renderChoices", value: function (e, t) {
                            var i = this, n = t || document.createDocumentFragment(), s = this.isSearching ? v.sortByScore : this.config.sortFilter, o = this.config.renderSelectedChoices, r = function (e) {
                                var t = "auto" !== o || (i.isSelectOneElement || !e.selected);
                                if (t) {
                                    var s = i._getTemplate("choice", e);
                                    n.appendChild(s)
                                }
                            };
                            if ((this.config.shouldSort || this.isSearching) && e.sort(s), this.isSearching)
                                for (var a = 0; a < this.config.searchResultLimit; a++) {
                                    var c = e[a];
                                    c && r(c)
                                }
                            else
                                e.forEach(function (e) {
                                    return r(e)
                                });
                            return n
                        }}, {key: "renderItems", value: function (e) {
                            var t = this, i = arguments.length > 1 && void 0 !== arguments[1] ? arguments[1] : null, n = i || document.createDocumentFragment();
                            if (this.config.shouldSortItems && !this.isSelectOneElement && e.sort(this.config.sortFilter), this.isTextElement) {
                                var s = this.store.getItemsReducedToValues(e), o = s.join(this.config.delimiter);
                                this.passedElement.setAttribute("value", o), this.passedElement.value = o
                            } else {
                                var r = document.createDocumentFragment();
                                e.forEach(function (e) {
                                    var i = t._getTemplate("option", e);
                                    r.appendChild(i)
                                }), this.passedElement.innerHTML = "", this.passedElement.appendChild(r)
                            }
                            return e.forEach(function (e) {
                                var i = t._getTemplate("item", e);
                                n.appendChild(i)
                            }), n
                        }}, {key: "render", value: function () {
                            if (this.currentState = this.store.getState(), this.currentState !== this.prevState) {
                                if ((this.currentState.choices !== this.prevState.choices || this.currentState.groups !== this.prevState.groups) && this.isSelectElement) {
                                    var e = this.store.getGroupsFilteredByActive(), t = this.store.getChoicesFilteredByActive(), i = document.createDocumentFragment();
                                    this.choiceList.innerHTML = "", this.config.resetScrollPosition && (this.choiceList.scrollTop = 0), e.length >= 1 && this.isSearching !== !0 ? i = this.renderGroups(e, t, i) : t.length >= 1 && (i = this.renderChoices(t, i));
                                    var n = this.store.getItemsFilteredByActive(), s = this._canAddItem(n, this.input.value);
                                    if (i.childNodes && i.childNodes.length > 0)
                                        s.response ? (this.choiceList.appendChild(i), this._highlightChoice()) : this.choiceList.appendChild(this._getTemplate("notice", s.notice));
                                    else {
                                        var o = void 0, r = void 0;
                                        this.isSearching ? (r = (0, v.isType)("Function", this.config.noResultsText) ? this.config.noResultsText() : this.config.noResultsText, o = this._getTemplate("notice", r)) : (r = (0, v.isType)("Function", this.config.noChoicesText) ? this.config.noChoicesText() : this.config.noChoicesText, o = this._getTemplate("notice", r)), this.choiceList.appendChild(o)
                                    }
                                }
                                if (this.currentState.items !== this.prevState.items) {
                                    var a = this.store.getItemsFilteredByActive();
                                    if (a) {
                                        var c = this.renderItems(a);
                                        this.itemList.innerHTML = "", c.childNodes && this.itemList.appendChild(c)
                                    }
                                }
                                this.prevState = this.currentState
                            }
                        }}, {key: "highlightItem", value: function (e) {
                            var t = !(arguments.length > 1 && void 0 !== arguments[1]) || arguments[1];
                            if (!e)
                                return this;
                            var i = e.id, n = e.groupId, s = n >= 0 ? this.store.getGroupById(n) : null;
                            return this.store.dispatch((0, p.highlightItem)(i, !0)), t && (s && s.value ? (0, v.triggerEvent)(this.passedElement, "highlightItem", {id: i, value: e.value, label: e.label, groupValue: s.value}) : (0, v.triggerEvent)(this.passedElement, "highlightItem", {id: i, value: e.value, label: e.label})), this
                        }}, {key: "unhighlightItem", value: function (e) {
                            if (!e)
                                return this;
                            var t = e.id, i = e.groupId, n = i >= 0 ? this.store.getGroupById(i) : null;
                            return this.store.dispatch((0, p.highlightItem)(t, !1)), n && n.value ? (0, v.triggerEvent)(this.passedElement, "unhighlightItem", {id: t, value: e.value, label: e.label, groupValue: n.value}) : (0, v.triggerEvent)(this.passedElement, "unhighlightItem", {id: t, value: e.value, label: e.label}), this
                        }}, {key: "highlightAll", value: function () {
                            var e = this, t = this.store.getItems();
                            return t.forEach(function (t) {
                                e.highlightItem(t)
                            }), this
                        }}, {key: "unhighlightAll", value: function () {
                            var e = this, t = this.store.getItems();
                            return t.forEach(function (t) {
                                e.unhighlightItem(t)
                            }), this
                        }}, {key: "removeItemsByValue", value: function (e) {
                            var t = this;
                            if (!e || !(0, v.isType)("String", e))
                                return this;
                            var i = this.store.getItemsFilteredByActive();
                            return i.forEach(function (i) {
                                i.value === e && t._removeItem(i)
                            }), this
                        }}, {key: "removeActiveItems", value: function (e) {
                            var t = this, i = this.store.getItemsFilteredByActive();
                            return i.forEach(function (i) {
                                i.active && e !== i.id && t._removeItem(i)
                            }), this
                        }}, {key: "removeHighlightedItems", value: function () {
                            var e = this, t = arguments.length > 0 && void 0 !== arguments[0] && arguments[0], i = this.store.getItemsFilteredByActive();
                            return i.forEach(function (i) {
                                i.highlighted && i.active && (e._removeItem(i), t && e._triggerChange(i.value))
                            }), this
                        }}, {key: "showDropdown", value: function () {
                            var e = arguments.length > 0 && void 0 !== arguments[0] && arguments[0], t = document.body, i = document.documentElement, n = Math.max(t.scrollHeight, t.offsetHeight, i.clientHeight, i.scrollHeight, i.offsetHeight);
                            this.containerOuter.classList.add(this.config.classNames.openState), this.containerOuter.setAttribute("aria-expanded", "true"), this.dropdown.classList.add(this.config.classNames.activeState), this.dropdown.setAttribute("aria-expanded", "true");
                            var s = this.dropdown.getBoundingClientRect(), o = Math.ceil(s.top + window.scrollY + this.dropdown.offsetHeight), r = !1;
                            return"auto" === this.config.position ? r = o >= n : "top" === this.config.position && (r = !0), r && this.containerOuter.classList.add(this.config.classNames.flippedState), e && this.canSearch && document.activeElement !== this.input && this.input.focus(), (0, v.triggerEvent)(this.passedElement, "showDropdown", {}), this
                        }}, {key: "hideDropdown", value: function () {
                            var e = arguments.length > 0 && void 0 !== arguments[0] && arguments[0], t = this.containerOuter.classList.contains(this.config.classNames.flippedState);
                            return this.containerOuter.classList.remove(this.config.classNames.openState), this.containerOuter.setAttribute("aria-expanded", "false"), this.dropdown.classList.remove(this.config.classNames.activeState), this.dropdown.setAttribute("aria-expanded", "false"), t && this.containerOuter.classList.remove(this.config.classNames.flippedState), e && this.canSearch && document.activeElement === this.input && this.input.blur(), (0, v.triggerEvent)(this.passedElement, "hideDropdown", {}), this
                        }}, {key: "toggleDropdown", value: function () {
                            var e = this.dropdown.classList.contains(this.config.classNames.activeState);
                            return e ? this.hideDropdown() : this.showDropdown(!0), this
                        }}, {key: "getValue", value: function () {
                            var e = this, t = arguments.length > 0 && void 0 !== arguments[0] && arguments[0], i = this.store.getItemsFilteredByActive(), n = [];
                            return i.forEach(function (i) {
                                e.isTextElement ? n.push(t ? i.value : i) : i.active && n.push(t ? i.value : i)
                            }), this.isSelectOneElement ? n[0] : n
                        }}, {key: "setValue", value: function (e) {
                            var t = this;
                            if (this.initialised === !0) {
                                var i = [].concat(o(e)), n = function (e) {
                                    var i = (0, v.getType)(e);
                                    if ("Object" === i) {
                                        if (!e.value)
                                            return;
                                        t.isTextElement ? t._addItem(e.value, e.label, e.id, void 0, e.customProperties, null) : t._addChoice(e.value, e.label, !0, !1, -1, e.customProperties, null)
                                    } else
                                        "String" === i && (t.isTextElement ? t._addItem(e) : t._addChoice(e, e, !0, !1, -1, null))
                                };
                                i.length > 1 ? i.forEach(function (e) {
                                    n(e)
                                }) : n(i[0])
                            }
                            return this
                        }}, {key: "setValueByChoice", value: function (e) {
                            var t = this;
                            if (!this.isTextElement) {
                                var i = this.store.getChoices(), n = (0, v.isType)("Array", e) ? e : [e];
                                n.forEach(function (e) {
                                    var n = i.find(function (t) {
                                        return t.value === e
                                    });
                                    n ? n.selected ? t.config.silent || console.warn("Attempting to select choice already selected") : t._addItem(n.value, n.label, n.id, n.groupId, n.customProperties, n.keyCode) : t.config.silent || console.warn("Attempting to select choice that does not exist")
                                })
                            }
                            return this
                        }}, {key: "setChoices", value: function (e, t, i) {
                            var n = this, s = arguments.length > 3 && void 0 !== arguments[3] && arguments[3];
                            if (this.initialised === !0 && this.isSelectElement) {
                                if (!(0, v.isType)("Array", e) || !t)
                                    return this;
                                s && this._clearChoices(), e && e.length && (this.containerOuter.classList.remove(this.config.classNames.loadingState), e.forEach(function (e) {
                                    e.choices ? n._addGroup(e, e.id || null, t, i) : n._addChoice(e[t], e[i], e.selected, e.disabled, void 0, e.customProperties, null)
                                }))
                            }
                            return this
                        }}, {key: "clearStore", value: function () {
                            return this.store.dispatch((0, p.clearAll)()), this
                        }}, {key: "clearInput", value: function () {
                            return this.input.value && (this.input.value = ""), this.isSelectOneElement || this._setInputWidth(), !this.isTextElement && this.config.searchEnabled && (this.isSearching = !1, this.store.dispatch((0, p.activateChoices)(!0))), this
                        }}, {key: "enable", value: function () {
                            this.passedElement.disabled = !1;
                            var e = this.containerOuter.classList.contains(this.config.classNames.disabledState);
                            return this.initialised && e && (this._addEventListeners(), this.passedElement.removeAttribute("disabled"), this.input.removeAttribute("disabled"), this.containerOuter.classList.remove(this.config.classNames.disabledState), this.containerOuter.removeAttribute("aria-disabled"), this.isSelectOneElement && this.containerOuter.setAttribute("tabindex", "0")), this
                        }}, {key: "disable", value: function () {
                            this.passedElement.disabled = !0;
                            var e = !this.containerOuter.classList.contains(this.config.classNames.disabledState);
                            return this.initialised && e && (this._removeEventListeners(), this.passedElement.setAttribute("disabled", ""), this.input.setAttribute("disabled", ""), this.containerOuter.classList.add(this.config.classNames.disabledState), this.containerOuter.setAttribute("aria-disabled", "true"), this.isSelectOneElement && this.containerOuter.setAttribute("tabindex", "-1")), this
                        }}, {key: "ajax", value: function (e) {
                            var t = this;
                            return this.initialised === !0 && this.isSelectElement && (requestAnimationFrame(function () {
                                t._handleLoadingState(!0)
                            }), e(this._ajaxCallback())), this
                        }}, {key: "_triggerChange", value: function (e) {
                            e && (0, v.triggerEvent)(this.passedElement, "change", {value: e})
                        }}, {key: "_handleButtonAction", value: function (e, t) {
                            if (e && t && this.config.removeItems && this.config.removeItemButton) {
                                var i = t.parentNode.getAttribute("data-id"), n = e.find(function (e) {
                                    return e.id === parseInt(i, 10)
                                });
                                if (this._removeItem(n), this._triggerChange(n.value), this.isSelectOneElement) {
                                    var s = !!this.config.placeholder && (this.config.placeholderValue || this.passedElement.getAttribute("placeholder"));
                                    if (s) {
                                        var o = this._getTemplate("placeholder", s);
                                        this.itemList.appendChild(o)
                                    }
                                }
                            }
                        }}, {key: "_handleItemAction", value: function (e, t) {
                            var i = this, n = arguments.length > 2 && void 0 !== arguments[2] && arguments[2];
                            if (e && t && this.config.removeItems && !this.isSelectOneElement) {
                                var s = t.getAttribute("data-id");
                                e.forEach(function (e) {
                                    e.id !== parseInt(s, 10) || e.highlighted ? n || e.highlighted && i.unhighlightItem(e) : i.highlightItem(e)
                                }), document.activeElement !== this.input && this.input.focus()
                            }
                        }}, {key: "_handleChoiceAction", value: function (e, t) {
                            if (e && t) {
                                var i = t.getAttribute("data-id"), n = this.store.getChoiceById(i), s = e[0] && e[0].keyCode ? e[0].keyCode : null, o = this.dropdown.classList.contains(this.config.classNames.activeState);
                                if (n.keyCode = s, (0, v.triggerEvent)(this.passedElement, "choice", {choice: n}), n && !n.selected && !n.disabled) {
                                    var r = this._canAddItem(e, n.value);
                                    r.response && (this._addItem(n.value, n.label, n.id, n.groupId, n.customProperties, n.keyCode), this._triggerChange(n.value))
                                }
                                this.clearInput(), o && this.isSelectOneElement && (this.hideDropdown(), this.containerOuter.focus())
                            }
                        }}, {key: "_handleBackspace", value: function (e) {
                            if (this.config.removeItems && e) {
                                var t = e[e.length - 1], i = e.some(function (e) {
                                    return e.highlighted
                                });
                                this.config.editItems && !i && t ? (this.input.value = t.value, this._setInputWidth(), this._removeItem(t), this._triggerChange(t.value)) : (i || this.highlightItem(t, !1), this.removeHighlightedItems(!0))
                            }
                        }}, {key: "_canAddItem", value: function (e, t) {
                            var i = !0, n = (0, v.isType)("Function", this.config.addItemText) ? this.config.addItemText(t) : this.config.addItemText;
                            (this.isSelectMultipleElement || this.isTextElement) && this.config.maxItemCount > 0 && this.config.maxItemCount <= e.length && (i = !1, n = (0, v.isType)("Function", this.config.maxItemText) ? this.config.maxItemText(this.config.maxItemCount) : this.config.maxItemText), this.isTextElement && this.config.addItems && i && this.config.regexFilter && (i = this._regexFilter(t));
                            var s = !e.some(function (e) {
                                return(0, v.isType)("String", t) ? e.value === t.trim() : e.value === t
                            });
                            return s || this.config.duplicateItems || this.isSelectOneElement || !i || (i = !1, n = (0, v.isType)("Function", this.config.uniqueItemText) ? this.config.uniqueItemText(t) : this.config.uniqueItemText), {response: i, notice: n}
                        }}, {key: "_handleLoadingState", value: function () {
                            var e = !(arguments.length > 0 && void 0 !== arguments[0]) || arguments[0], t = this.itemList.querySelector("." + this.config.classNames.placeholder);
                            if (e)
                                this.containerOuter.classList.add(this.config.classNames.loadingState), this.containerOuter.setAttribute("aria-busy", "true"), this.isSelectOneElement ? t ? t.innerHTML = this.config.loadingText : (t = this._getTemplate("placeholder", this.config.loadingText), this.itemList.appendChild(t)) : this.input.placeholder = this.config.loadingText;
                            else {
                                this.containerOuter.classList.remove(this.config.classNames.loadingState);
                                var i = !!this.config.placeholder && (this.config.placeholderValue || this.passedElement.getAttribute("placeholder"));
                                this.isSelectOneElement ? t.innerHTML = i || "" : this.input.placeholder = i || ""
                            }
                        }}, {key: "_ajaxCallback", value: function () {
                            var e = this;
                            return function (t, i, n) {
                                if (t && i) {
                                    var s = (0, v.isType)("Object", t) ? [t] : t;
                                    s && (0, v.isType)("Array", s) && s.length ? (e._handleLoadingState(!1), s.forEach(function (t) {
                                        if (t.choices) {
                                            var s = t.id || null;
                                            e._addGroup(t, s, i, n)
                                        } else
                                            e._addChoice(t[i], t[n], t.selected, t.disabled, void 0, t.customProperties, null)
                                    })) : e._handleLoadingState(!1), e.containerOuter.removeAttribute("aria-busy")
                                }
                            }
                        }}, {key: "_searchChoices", value: function (e) {
                            var t = (0, v.isType)("String", e) ? e.trim() : e, i = (0, v.isType)("String", this.currentValue) ? this.currentValue.trim() : this.currentValue;
                            if (t.length >= 1 && t !== i + " ") {
                                var n = this.store.getChoicesFilteredBySelectable(), s = t, o = (0, v.isType)("Array", this.config.searchFields) ? this.config.searchFields : [this.config.searchFields], r = Object.assign(this.config.fuseOptions, {keys: o}), a = new l.default(n, r), c = a.search(s);
                                this.currentValue = t, this.highlightPosition = 0, this.isSearching = !0, this.store.dispatch((0, p.filterChoices)(c))
                            }
                        }}, {key: "_handleSearch", value: function (e) {
                            if (e) {
                                var t = this.store.getChoices(), i = t.some(function (e) {
                                    return!e.active
                                });
                                this.input === document.activeElement && (e && e.length >= this.config.searchFloor ? (this.config.searchChoices && this._searchChoices(e), (0, v.triggerEvent)(this.passedElement, "search", {value: e})) : i && (this.isSearching = !1, this.store.dispatch((0, p.activateChoices)(!0))))
                            }
                        }}, {key: "_addEventListeners", value: function () {
                            document.addEventListener("keyup", this._onKeyUp), document.addEventListener("keydown", this._onKeyDown), document.addEventListener("click", this._onClick), document.addEventListener("touchmove", this._onTouchMove), document.addEventListener("touchend", this._onTouchEnd), document.addEventListener("mousedown", this._onMouseDown), document.addEventListener("mouseover", this._onMouseOver), this.isSelectOneElement && (this.containerOuter.addEventListener("focus", this._onFocus), this.containerOuter.addEventListener("blur", this._onBlur)), this.input.addEventListener("input", this._onInput), this.input.addEventListener("paste", this._onPaste), this.input.addEventListener("focus", this._onFocus), this.input.addEventListener("blur", this._onBlur)
                        }}, {key: "_removeEventListeners", value: function () {
                            document.removeEventListener("keyup", this._onKeyUp), document.removeEventListener("keydown", this._onKeyDown), document.removeEventListener("click", this._onClick), document.removeEventListener("touchmove", this._onTouchMove), document.removeEventListener("touchend", this._onTouchEnd), document.removeEventListener("mousedown", this._onMouseDown), document.removeEventListener("mouseover", this._onMouseOver), this.isSelectOneElement && (this.containerOuter.removeEventListener("focus", this._onFocus), this.containerOuter.removeEventListener("blur", this._onBlur)), this.input.removeEventListener("input", this._onInput), this.input.removeEventListener("paste", this._onPaste), this.input.removeEventListener("focus", this._onFocus), this.input.removeEventListener("blur", this._onBlur)
                        }}, {key: "_setInputWidth", value: function () {
                            if (this.config.placeholderValue || this.passedElement.getAttribute("placeholder") && this.config.placeholder) {
                                var e = !!this.config.placeholder && (this.config.placeholderValue || this.passedElement.getAttribute("placeholder"));
                                this.input.value && this.input.value.length >= e.length / 1.25 && (this.input.style.width = (0, v.getWidthOfInput)(this.input))
                            } else
                                this.input.style.width = (0, v.getWidthOfInput)(this.input)
                        }}, {key: "_onKeyDown", value: function (e) {
                            var t, i = this;
                            if (e.target === this.input || this.containerOuter.contains(e.target)) {
                                var n = e.target, o = this.store.getItemsFilteredByActive(), r = this.input === document.activeElement, a = this.dropdown.classList.contains(this.config.classNames.activeState), c = this.itemList && this.itemList.children, l = String.fromCharCode(e.keyCode), u = 46, h = 8, d = 13, f = 65, p = 27, m = 38, g = 40, y = 33, b = 34, E = e.ctrlKey || e.metaKey;
                                this.isTextElement || !/[a-zA-Z0-9-_ ]/.test(l) || a || this.showDropdown(!0), this.canSearch = this.config.searchEnabled;
                                var _ = function () {
                                    E && c && (i.canSearch = !1, i.config.removeItems && !i.input.value && i.input === document.activeElement && i.highlightAll())
                                }, S = function () {
                                    if (i.isTextElement && n.value) {
                                        var t = i.input.value, s = i._canAddItem(o, t);
                                        s.response && (a && i.hideDropdown(), i._addItem(t), i._triggerChange(t), i.clearInput())
                                    }
                                    if (n.hasAttribute("data-button") && (i._handleButtonAction(o, n), e.preventDefault()), a) {
                                        e.preventDefault();
                                        var r = i.dropdown.querySelector("." + i.config.classNames.highlightedState);
                                        r && (o[0] && (o[0].keyCode = d), i._handleChoiceAction(o, r))
                                    } else
                                        i.isSelectOneElement && (a || (i.showDropdown(!0), e.preventDefault()))
                                }, I = function () {
                                    a && (i.toggleDropdown(), i.containerOuter.focus())
                                }, w = function () {
                                    if (a || i.isSelectOneElement) {
                                        a || i.showDropdown(!0), i.canSearch = !1;
                                        var t = e.keyCode === g || e.keyCode === b ? 1 : -1, n = e.metaKey || e.keyCode === b || e.keyCode === y, s = void 0;
                                        if (n)
                                            s = t > 0 ? Array.from(i.dropdown.querySelectorAll("[data-choice-selectable]")).pop() : i.dropdown.querySelector("[data-choice-selectable]");
                                        else {
                                            var o = i.dropdown.querySelector("." + i.config.classNames.highlightedState);
                                            s = o ? (0, v.getAdjacentEl)(o, "[data-choice-selectable]", t) : i.dropdown.querySelector("[data-choice-selectable]")
                                        }
                                        s && ((0, v.isScrolledIntoView)(s, i.choiceList, t) || i._scrollToChoice(s, t), i._highlightChoice(s)), e.preventDefault()
                                    }
                                }, T = function () {
                                    !r || e.target.value || i.isSelectOneElement || (i._handleBackspace(o), e.preventDefault())
                                }, A = (t = {}, s(t, f, _), s(t, d, S), s(t, p, I), s(t, m, w), s(t, y, w), s(t, g, w), s(t, b, w), s(t, h, T), s(t, u, T), t);
                                A[e.keyCode] && A[e.keyCode]()
                            }
                        }}, {key: "_onKeyUp", value: function (e) {
                            if (e.target === this.input) {
                                var t = this.input.value, i = this.store.getItemsFilteredByActive(), n = this._canAddItem(i, t);
                                if (this.isTextElement) {
                                    var s = this.dropdown.classList.contains(this.config.classNames.activeState);
                                    if (t) {
                                        if (n.notice) {
                                            var o = this._getTemplate("notice", n.notice);
                                            this.dropdown.innerHTML = o.outerHTML
                                        }
                                        n.response === !0 ? s || this.showDropdown() : !n.notice && s && this.hideDropdown()
                                    } else
                                        s && this.hideDropdown()
                                } else {
                                    var r = 46, a = 8;
                                    e.keyCode !== r && e.keyCode !== a || e.target.value ? this.canSearch && n.response && this._handleSearch(this.input.value) : !this.isTextElement && this.isSearching && (this.isSearching = !1, this.store.dispatch((0, p.activateChoices)(!0)))
                                }
                                this.canSearch = this.config.searchEnabled
                            }
                        }}, {key: "_onInput", value: function () {
                            this.isSelectOneElement || this._setInputWidth()
                        }}, {key: "_onTouchMove", value: function () {
                            this.wasTap === !0 && (this.wasTap = !1)
                        }}, {key: "_onTouchEnd", value: function (e) {
                            var t = e.target || e.touches[0].target, i = this.dropdown.classList.contains(this.config.classNames.activeState);
                            this.wasTap === !0 && this.containerOuter.contains(t) && (t !== this.containerOuter && t !== this.containerInner || this.isSelectOneElement || (this.isTextElement ? document.activeElement !== this.input && this.input.focus() : i || this.showDropdown(!0)), e.stopPropagation()), this.wasTap = !0
                        }}, {key: "_onMouseDown", value: function (e) {
                            var t = e.target;
                            if (this.containerOuter.contains(t) && t !== this.input) {
                                var i = void 0, n = this.store.getItemsFilteredByActive(), s = e.shiftKey;
                                (i = (0, v.findAncestorByAttrName)(t, "data-button")) ? this._handleButtonAction(n, i) : (i = (0, v.findAncestorByAttrName)(t, "data-item")) ? this._handleItemAction(n, i, s) : (i = (0, v.findAncestorByAttrName)(t, "data-choice")) && this._handleChoiceAction(n, i), e.preventDefault()
                            }
                        }}, {key: "_onClick", value: function (e) {
                            var t = e.target, i = this.dropdown.classList.contains(this.config.classNames.activeState), n = this.store.getItemsFilteredByActive();
                            if (this.containerOuter.contains(t))
                                t.hasAttribute("data-button") && this._handleButtonAction(n, t), i ? this.isSelectOneElement && t !== this.input && !this.dropdown.contains(t) && this.hideDropdown(!0) : this.isTextElement ? document.activeElement !== this.input && this.input.focus() : this.canSearch ? this.showDropdown(!0) : (this.showDropdown(), this.containerOuter.focus());
                            else {
                                var s = n.some(function (e) {
                                    return e.highlighted
                                });
                                s && this.unhighlightAll(), this.containerOuter.classList.remove(this.config.classNames.focusState), i && this.hideDropdown()
                            }
                        }}, {key: "_onMouseOver", value: function (e) {
                            (e.target === this.dropdown || this.dropdown.contains(e.target)) && e.target.hasAttribute("data-choice") && this._highlightChoice(e.target)
                        }}, {key: "_onPaste", value: function (e) {
                            e.target !== this.input || this.config.paste || e.preventDefault()
                        }}, {key: "_onFocus", value: function (e) {
                            var t = this, i = e.target;
                            if (this.containerOuter.contains(i)) {
                                var n = this.dropdown.classList.contains(this.config.classNames.activeState), s = {text: function () {
                                        i === t.input && t.containerOuter.classList.add(t.config.classNames.focusState)
                                    }, "select-one": function () {
                                        t.containerOuter.classList.add(t.config.classNames.focusState), i === t.input && (n || t.showDropdown())
                                    }, "select-multiple": function () {
                                        i === t.input && (t.containerOuter.classList.add(t.config.classNames.focusState), n || t.showDropdown(!0))
                                    }};
                                s[this.passedElement.type]()
                            }
                        }}, {key: "_onBlur", value: function (e) {
                            var t = this, i = e.target;
                            if (this.containerOuter.contains(i)) {
                                var n = this.store.getItemsFilteredByActive(), s = this.dropdown.classList.contains(this.config.classNames.activeState), o = n.some(function (e) {
                                    return e.highlighted
                                }), r = {text: function () {
                                        i === t.input && (t.containerOuter.classList.remove(t.config.classNames.focusState), o && t.unhighlightAll(), s && t.hideDropdown())
                                    }, "select-one": function () {
                                        t.containerOuter.classList.remove(t.config.classNames.focusState), i === t.containerOuter && s && !t.canSearch && t.hideDropdown(), i === t.input && s && t.hideDropdown()
                                    }, "select-multiple": function () {
                                        i === t.input && (t.containerOuter.classList.remove(t.config.classNames.focusState), s && t.hideDropdown(), o && t.unhighlightAll())
                                    }};
                                r[this.passedElement.type]()
                            }
                        }}, {key: "_regexFilter", value: function (e) {
                            if (!e)
                                return!1;
                            var t = this.config.regexFilter, i = new RegExp(t.source, "i");
                            return i.test(e)
                        }}, {key: "_scrollToChoice", value: function (e, t) {
                            var i = this;
                            if (e) {
                                var n = this.choiceList.offsetHeight, s = e.offsetHeight, o = e.offsetTop + s, r = this.choiceList.scrollTop + n, a = t > 0 ? this.choiceList.scrollTop + o - r : e.offsetTop, c = function e() {
                                    var n = 4, s = i.choiceList.scrollTop, o = !1, r = void 0, c = void 0;
                                    t > 0 ? (r = (a - s) / n, c = r > 1 ? r : 1, i.choiceList.scrollTop = s + c, s < a && (o = !0)) : (r = (s - a) / n, c = r > 1 ? r : 1, i.choiceList.scrollTop = s - c, s > a && (o = !0)), o && requestAnimationFrame(function (i) {
                                        e(i, a, t)
                                    })
                                };
                                requestAnimationFrame(function (e) {
                                    c(e, a, t)
                                })
                            }
                        }}, {key: "_highlightChoice", value: function () {
                            var e = this, t = arguments.length > 0 && void 0 !== arguments[0] ? arguments[0] : null, i = Array.from(this.dropdown.querySelectorAll("[data-choice-selectable]")), n = t;
                            if (i && i.length) {
                                var s = Array.from(this.dropdown.querySelectorAll("." + this.config.classNames.highlightedState));
                                s.forEach(function (t) {
                                    t.classList.remove(e.config.classNames.highlightedState), t.setAttribute("aria-selected", "false")
                                }), n ? this.highlightPosition = i.indexOf(n) : (n = i.length > this.highlightPosition ? i[this.highlightPosition] : i[i.length - 1], n || (n = i[0])), n.classList.add(this.config.classNames.highlightedState), n.setAttribute("aria-selected", "true"), this.containerOuter.setAttribute("aria-activedescendant", n.id), this.input.setAttribute("aria-activedescendant", n.id)
                            }
                        }}, {key: "_addItem", value: function (e) {
                            var t = arguments.length > 1 && void 0 !== arguments[1] ? arguments[1] : null, i = arguments.length > 2 && void 0 !== arguments[2] ? arguments[2] : -1, n = arguments.length > 3 && void 0 !== arguments[3] ? arguments[3] : -1, s = arguments.length > 4 && void 0 !== arguments[4] ? arguments[4] : null, o = arguments.length > 5 && void 0 !== arguments[5] ? arguments[5] : null, r = (0, v.isType)("String", e) ? e.trim() : e, a = o, c = this.store.getItems(), l = t || r, u = parseInt(i, 10) || -1, h = n >= 0 ? this.store.getGroupById(n) : null, d = c ? c.length + 1 : 1;
                            return this.config.prependValue && (r = this.config.prependValue + r.toString()), this.config.appendValue && (r += this.config.appendValue.toString()), this.store.dispatch((0, p.addItem)(r, l, d, u, n, s, a)), this.isSelectOneElement && this.removeActiveItems(d), h && h.value ? (0, v.triggerEvent)(this.passedElement, "addItem", {id: d, value: r, label: l, groupValue: h.value, keyCode: a}) : (0, v.triggerEvent)(this.passedElement, "addItem", {id: d, value: r, label: l, keyCode: a}), this
                        }}, {key: "_removeItem", value: function (e) {
                            if (!e || !(0, v.isType)("Object", e))
                                return this;
                            var t = e.id, i = e.value, n = e.label, s = e.choiceId, o = e.groupId, r = o >= 0 ? this.store.getGroupById(o) : null;
                            return this.store.dispatch((0, p.removeItem)(t, s)), r && r.value ? (0, v.triggerEvent)(this.passedElement, "removeItem", {id: t, value: i, label: n, groupValue: r.value}) : (0, v.triggerEvent)(this.passedElement, "removeItem", {id: t, value: i, label: n}), this
                        }}, {key: "_addChoice", value: function (e) {
                            var t = arguments.length > 1 && void 0 !== arguments[1] ? arguments[1] : null, i = arguments.length > 2 && void 0 !== arguments[2] && arguments[2], n = arguments.length > 3 && void 0 !== arguments[3] && arguments[3], s = arguments.length > 4 && void 0 !== arguments[4] ? arguments[4] : -1, o = arguments.length > 5 && void 0 !== arguments[5] ? arguments[5] : null, r = arguments.length > 6 && void 0 !== arguments[6] ? arguments[6] : null;
                            if ("undefined" != typeof e && null !== e) {
                                var a = this.store.getChoices(), c = t || e, l = a ? a.length + 1 : 1, u = this.baseId + "-" + this.idNames.itemChoice + "-" + l;
                                this.store.dispatch((0, p.addChoice)(e, c, l, s, n, u, o, r)), i && this._addItem(e, c, l, void 0, o, r)
                            }
                        }}, {key: "_clearChoices", value: function () {
                            this.store.dispatch((0, p.clearChoices)())
                        }}, {key: "_addGroup", value: function (e, t) {
                            var i = this, n = arguments.length > 2 && void 0 !== arguments[2] ? arguments[2] : "value", s = arguments.length > 3 && void 0 !== arguments[3] ? arguments[3] : "label", o = (0, v.isType)("Object", e) ? e.choices : Array.from(e.getElementsByTagName("OPTION")), r = t ? t : Math.floor((new Date).valueOf() * Math.random()), a = !!e.disabled && e.disabled;
                            o ? (this.store.dispatch((0, p.addGroup)(e.label, r, !0, a)), o.forEach(function (e) {
                                var t = e.disabled || e.parentNode && e.parentNode.disabled, o = (0, v.isType)("Object", e) ? e[s] : e.innerHTML;
                                i._addChoice(e[n], o, e.selected, t, r, e.customProperties)
                            })) : this.store.dispatch((0, p.addGroup)(e.label, e.id, !1, e.disabled))
                        }}, {key: "_getTemplate", value: function (e) {
                            if (!e)
                                return null;
                            for (var t = this.config.templates, i = arguments.length, n = Array(i > 1 ? i - 1 : 0), s = 1; s < i; s++)
                                n[s - 1] = arguments[s];
                            return t[e].apply(t, n)
                        }}, {key: "_createTemplates", value: function () {
                            var e = this, t = this.config.classNames, i = {containerOuter: function (i) {
                                    return(0, v.strToEl)('\n          <div\n            class="' + t.containerOuter + '"\n            ' + (e.isSelectElement ? e.config.searchEnabled ? 'role="combobox" aria-autocomplete="list"' : 'role="listbox"' : "") + '\n            data-type="' + e.passedElement.type + '"\n            ' + (e.isSelectOneElement ? 'tabindex="0"' : "") + '\n            aria-haspopup="true"\n            aria-expanded="false"\n            dir="' + i + '"\n            >\n          </div>\n        ')
                                }, containerInner: function () {
                                    return(0, v.strToEl)('\n          <div class="' + t.containerInner + '"></div>\n        ')
                                }, itemList: function () {
                                    var i, n = (0, h.default)(t.list, (i = {}, s(i, t.listSingle, e.isSelectOneElement), s(i, t.listItems, !e.isSelectOneElement), i));
                                    return(0, v.strToEl)('\n          <div class="' + n + '"></div>\n        ')
                                }, placeholder: function (e) {
                                    return(0, v.strToEl)('\n          <div class="' + t.placeholder + '">\n            ' + e + "\n          </div>\n        ")
                                }, item: function (i) {
                                    var n, o = (0, h.default)(t.item, (n = {}, s(n, t.highlightedState, i.highlighted), s(n, t.itemSelectable, !i.highlighted), n));
                                    if (e.config.removeItemButton) {
                                        var r;
                                        return o = (0, h.default)(t.item, (r = {}, s(r, t.highlightedState, i.highlighted), s(r, t.itemSelectable, !i.disabled), r)), (0, v.strToEl)('\n            <div\n              class="' + o + '"\n              data-item\n              data-id="' + i.id + '"\n              data-value="' + i.value + '"\n              data-deletable\n              ' + (i.active ? 'aria-selected="true"' : "") + "\n              " + (i.disabled ? 'aria-disabled="true"' : "") + "\n              >\n              " + i.label + '<!--\n           --><button\n                type="button"\n                class="' + t.button + '"\n                data-button\n                aria-label="Remove item: \'' + i.value + "'\"\n                >\n                Remove item\n              </button>\n            </div>\n          ")
                                    }
                                    return(0, v.strToEl)('\n          <div\n            class="' + o + '"\n            data-item\n            data-id="' + i.id + '"\n            data-value="' + i.value + '"\n            ' + (i.active ? 'aria-selected="true"' : "") + "\n            " + (i.disabled ? 'aria-disabled="true"' : "") + "\n            >\n            " + i.label + "\n          </div>\n        ")
                                }, choiceList: function () {
                                    return(0, v.strToEl)('\n          <div\n            class="' + t.list + '"\n            dir="ltr"\n            role="listbox"\n            ' + (e.isSelectOneElement ? "" : 'aria-multiselectable="true"') + "\n            >\n          </div>\n        ")
                                }, choiceGroup: function (e) {
                                    var i = (0, h.default)(t.group, s({}, t.itemDisabled, e.disabled));
                                    return(0, v.strToEl)('\n          <div\n            class="' + i + '"\n            data-group\n            data-id="' + e.id + '"\n            data-value="' + e.value + '"\n            role="group"\n            ' + (e.disabled ? 'aria-disabled="true"' : "") + '\n            >\n            <div class="' + t.groupHeading + '">' + e.value + "</div>\n          </div>\n        ")
                                }, choice: function (i) {
                                    var n, o = (0, h.default)(t.item, t.itemChoice, (n = {}, s(n, t.itemDisabled, i.disabled), s(n, t.itemSelectable, !i.disabled), n));
                                    return(0, v.strToEl)('\n          <div\n            class="' + o + '"\n            data-select-text="' + e.config.itemSelectText + '"\n            data-choice\n            data-id="' + i.id + '"\n            data-value="' + i.value + '"\n            ' + (i.disabled ? 'data-choice-disabled aria-disabled="true"' : "data-choice-selectable") + '\n            id="' + i.elementId + '"\n            ' + (i.groupId > 0 ? 'role="treeitem"' : 'role="option"') + "\n            >\n            " + i.label + "\n          </div>\n        ")
                                }, input: function () {
                                    var e = (0, h.default)(t.input, t.inputCloned);
                                    return(0, v.strToEl)('\n          <input\n            type="text"\n            class="' + e + '"\n            autocomplete="off"\n            autocapitalize="off"\n            spellcheck="false"\n            role="textbox"\n            aria-autocomplete="list"\n            >\n        ')
                                }, dropdown: function () {
                                    var e = (0, h.default)(t.list, t.listDropdown);
                                    return(0, v.strToEl)('\n          <div\n            class="' + e + '"\n            aria-expanded="false"\n            >\n          </div>\n        ')
                                }, notice: function (e) {
                                    var i = (0, h.default)(t.item, t.itemChoice);
                                    return(0, v.strToEl)('\n          <div class="' + i + '">\n            ' + e + "\n          </div>\n        ")
                                }, option: function (e) {
                                    return(0, v.strToEl)('\n          <option value="' + e.value + '" selected>' + e.label + "</option>\n        ")
                                }}, n = this.config.callbackOnCreateTemplates, o = {};
                            n && (0, v.isType)("Function", n) && (o = n.call(this, v.strToEl)), this.config.templates = (0, v.extend)(i, o)
                        }}, {key: "_createInput", value: function () {
                            var e = this, t = this.passedElement.getAttribute("dir") || "ltr", i = this._getTemplate("containerOuter", t), n = this._getTemplate("containerInner"), s = this._getTemplate("itemList"), o = this._getTemplate("choiceList"), r = this._getTemplate("input"), a = this._getTemplate("dropdown"), c = !!this.config.placeholder && (this.config.placeholderValue || this.passedElement.getAttribute("placeholder"));
                            this.containerOuter = i, this.containerInner = n, this.input = r, this.choiceList = o, this.itemList = s, this.dropdown = a, this.passedElement.classList.add(this.config.classNames.input, this.config.classNames.hiddenState), this.passedElement.tabIndex = "-1";
                            var l = this.passedElement.getAttribute("style");
                            if (Boolean(l) && this.passedElement.setAttribute("data-choice-orig-style", l), this.passedElement.setAttribute("style", "display:none;"), this.passedElement.setAttribute("aria-hidden", "true"), this.passedElement.setAttribute("data-choice", "active"), (0, v.wrap)(this.passedElement, n), (0, v.wrap)(n, i), c && (r.placeholder = c, this.isSelectOneElement || (r.style.width = (0, v.getWidthOfInput)(r))), this.config.addItems || this.disable(), i.appendChild(n), i.appendChild(a), n.appendChild(s), this.isTextElement || a.appendChild(o), this.isSelectMultipleElement || this.isTextElement ? n.appendChild(r) : this.canSearch && a.insertBefore(r, a.firstChild), this.isSelectElement) {
                                var u = Array.from(this.passedElement.getElementsByTagName("OPTGROUP"));
                                if (this.highlightPosition = 0, this.isSearching = !1, u && u.length)
                                    u.forEach(function (t) {
                                        e._addGroup(t, t.id || null)
                                    });
                                else {
                                    var h = Array.from(this.passedElement.options), d = this.config.sortFilter, f = this.presetChoices;
                                    h.forEach(function (e) {
                                        f.push({value: e.value, label: e.innerHTML, selected: e.selected, disabled: e.disabled || e.parentNode.disabled})
                                    }), this.config.shouldSort && f.sort(d);
                                    var p = f.some(function (e) {
                                        return e.selected
                                    });
                                    f.forEach(function (t, i) {
                                        e.isSelectOneElement ? p || !p && i > 0 ? e._addChoice(t.value, t.label, t.selected, t.disabled, void 0, t.customProperties) : e._addChoice(t.value, t.label, !0, !1, void 0, t.customProperties) : e._addChoice(t.value, t.label, t.selected, t.disabled, void 0, t.customProperties)
                                    })
                                }
                            } else
                                this.isTextElement && this.presetItems.forEach(function (t) {
                                    var i = (0, v.getType)(t);
                                    if ("Object" === i) {
                                        if (!t.value)
                                            return;
                                        e._addItem(t.value, t.label, t.id, void 0, t.customProperties)
                                    } else
                                        "String" === i && e._addItem(t)
                                })
                        }}]), e
            }();
            e.exports = m
        }, function (e, t, i) {
            !function (t) {
                "use strict";
                function i() {
                    console.log.apply(console, arguments)
                }
                function n(e, t) {
                    var i;
                    this.list = e, this.options = t = t || {};
                    for (i in a)
                        a.hasOwnProperty(i) && ("boolean" == typeof a[i] ? this.options[i] = i in t ? t[i] : a[i] : this.options[i] = t[i] || a[i])
                }
                function s(e, t, i) {
                    var n, r, a, c, l, u;
                    if (t) {
                        if (a = t.indexOf("."), a !== -1 ? (n = t.slice(0, a), r = t.slice(a + 1)) : n = t, c = e[n], null !== c && void 0 !== c)
                            if (r || "string" != typeof c && "number" != typeof c)
                                if (o(c))
                                    for (l = 0, u = c.length; l < u; l++)
                                        s(c[l], r, i);
                                else
                                    r && s(c, r, i);
                            else
                                i.push(c)
                    } else
                        i.push(e);
                    return i
                }
                function o(e) {
                    return"[object Array]" === Object.prototype.toString.call(e)
                }
                function r(e, t) {
                    t = t || {}, this.options = t, this.options.location = t.location || r.defaultOptions.location, this.options.distance = "distance"in t ? t.distance : r.defaultOptions.distance, this.options.threshold = "threshold"in t ? t.threshold : r.defaultOptions.threshold, this.options.maxPatternLength = t.maxPatternLength || r.defaultOptions.maxPatternLength, this.pattern = t.caseSensitive ? e : e.toLowerCase(), this.patternLen = e.length, this.patternLen <= this.options.maxPatternLength && (this.matchmask = 1 << this.patternLen - 1, this.patternAlphabet = this._calculatePatternAlphabet())
                }
                var a = {id: null, caseSensitive: !1, include: [], shouldSort: !0, searchFn: r, sortFn: function (e, t) {
                        return e.score - t.score
                    }, getFn: s, keys: [], verbose: !1, tokenize: !1, matchAllTokens: !1, tokenSeparator: / +/g, minMatchCharLength: 1, findAllMatches: !1};
                n.VERSION = "2.7.3", n.prototype.set = function (e) {
                    return this.list = e, e
                }, n.prototype.search = function (e) {
                    this.options.verbose && i("\nSearch term:", e, "\n"), this.pattern = e, this.results = [], this.resultMap = {}, this._keyMap = null, this._prepareSearchers(), this._startSearch(), this._computeScore(), this._sort();
                    var t = this._format();
                    return t
                }, n.prototype._prepareSearchers = function () {
                    var e = this.options, t = this.pattern, i = e.searchFn, n = t.split(e.tokenSeparator), s = 0, o = n.length;
                    if (this.options.tokenize)
                        for (this.tokenSearchers = []; s < o; s++)
                            this.tokenSearchers.push(new i(n[s], e));
                    this.fullSeacher = new i(t, e)
                }, n.prototype._startSearch = function () {
                    var e, t, i, n, s = this.options, o = s.getFn, r = this.list, a = r.length, c = this.options.keys, l = c.length, u = null;
                    if ("string" == typeof r[0])
                        for (i = 0; i < a; i++)
                            this._analyze("", r[i], i, i);
                    else
                        for (this._keyMap = {}, i = 0; i < a; i++)
                            for (u = r[i], n = 0; n < l; n++) {
                                if (e = c[n], "string" != typeof e) {
                                    if (t = 1 - e.weight || 1, this._keyMap[e.name] = {weight: t}, e.weight <= 0 || e.weight > 1)
                                        throw new Error("Key weight has to be > 0 and <= 1");
                                    e = e.name
                                } else
                                    this._keyMap[e] = {weight: 1};
                                this._analyze(e, o(u, e, []), u, i)
                            }
                }, n.prototype._analyze = function (e, t, n, s) {
                    var r, a, c, l, u, h, d, f, p, v, m, g, y, b, E, _ = this.options, S = !1;
                    if (void 0 !== t && null !== t) {
                        a = [];
                        var I = 0;
                        if ("string" == typeof t) {
                            if (r = t.split(_.tokenSeparator), _.verbose && i("---------\nKey:", e), this.options.tokenize) {
                                for (b = 0; b < this.tokenSearchers.length; b++) {
                                    for (f = this.tokenSearchers[b], _.verbose && i("Pattern:", f.pattern), p = [], g = !1, E = 0; E < r.length; E++) {
                                        v = r[E], m = f.search(v);
                                        var w = {};
                                        m.isMatch ? (w[v] = m.score, S = !0, g = !0, a.push(m.score)) : (w[v] = 1, this.options.matchAllTokens || a.push(1)), p.push(w)
                                    }
                                    g && I++, _.verbose && i("Token scores:", p)
                                }
                                for (l = a[0], h = a.length, b = 1; b < h; b++)
                                    l += a[b];
                                l /= h, _.verbose && i("Token score average:", l)
                            }
                            d = this.fullSeacher.search(t), _.verbose && i("Full text score:", d.score), u = d.score, void 0 !== l && (u = (u + l) / 2), _.verbose && i("Score average:", u), y = !this.options.tokenize || !this.options.matchAllTokens || I >= this.tokenSearchers.length, _.verbose && i("Check Matches", y), (S || d.isMatch) && y && (c = this.resultMap[s], c ? c.output.push({key: e, score: u, matchedIndices: d.matchedIndices}) : (this.resultMap[s] = {item: n, output: [{key: e, score: u, matchedIndices: d.matchedIndices}]}, this.results.push(this.resultMap[s])))
                        } else if (o(t))
                            for (b = 0; b < t.length; b++)
                                this._analyze(e, t[b], n, s)
                    }
                }, n.prototype._computeScore = function () {
                    var e, t, n, s, o, r, a, c, l, u = this._keyMap, h = this.results;
                    for (this.options.verbose && i("\n\nComputing score:\n"), e = 0; e < h.length; e++) {
                        for (n = 0, s = h[e].output, o = s.length, c = 1, t = 0; t < o; t++)
                            r = s[t].score, a = u ? u[s[t].key].weight : 1, l = r * a, 1 !== a ? c = Math.min(c, l) : (n += l, s[t].nScore = l);
                        1 === c ? h[e].score = n / o : h[e].score = c, this.options.verbose && i(h[e])
                    }
                }, n.prototype._sort = function () {
                    var e = this.options;
                    e.shouldSort && (e.verbose && i("\n\nSorting...."), this.results.sort(e.sortFn))
                }, n.prototype._format = function () {
                    var e, t, n, s, o = this.options, r = o.getFn, a = [], c = this.results, l = o.include;
                    for (o.verbose && i("\n\nOutput:\n\n", c), n = o.id?function(e){c[e].item = r(c[e].item, o.id, [])[0]}:function(){}, s = function(e){var t, i, n, s, o, r = c[e]; if (l.length > 0){if (t = {item:r.item}, l.indexOf("matches") !== - 1)for (n = r.output, t.matches = [], i = 0; i < n.length; i++)s = n[i], o = {indices:s.matchedIndices}, s.key && (o.key = s.key), t.matches.push(o); l.indexOf("score") !== - 1 && (t.score = c[e].score)} else t = r.item; return t}, e = 0, t = c.length; e < t; e++)
                        n(e), a.push(s(e));
                    return a
                }, r.defaultOptions = {location: 0, distance: 100, threshold: .6, maxPatternLength: 32}, r.prototype._calculatePatternAlphabet = function () {
                    var e = {}, t = 0;
                    for (t = 0; t < this.patternLen; t++)
                        e[this.pattern.charAt(t)] = 0;
                    for (t = 0; t < this.patternLen; t++)
                        e[this.pattern.charAt(t)] |= 1 << this.pattern.length - t - 1;
                    return e
                }, r.prototype._bitapScore = function (e, t) {
                    var i = e / this.patternLen, n = Math.abs(this.options.location - t);
                    return this.options.distance ? i + n / this.options.distance : n ? 1 : i
                }, r.prototype.search = function (e) {
                    var t, i, n, s, o, r, a, c, l, u, h, d, f, p, v, m, g, y, b, E, _, S, I, w = this.options;
                    if (e = w.caseSensitive ? e : e.toLowerCase(), this.pattern === e)
                        return{isMatch: !0, score: 0, matchedIndices: [[0, e.length - 1]]};
                    if (this.patternLen > w.maxPatternLength) {
                        if (y = e.match(new RegExp(this.pattern.replace(w.tokenSeparator, "|"))), b = !!y)
                            for (_ = [], t = 0, S = y.length; t < S; t++)
                                I = y[t], _.push([e.indexOf(I), I.length - 1]);
                        return{isMatch: b, score: b ? .5 : 1, matchedIndices: _}
                    }
                    for (s = w.findAllMatches, o = w.location, n = e.length, r = w.threshold, a = e.indexOf(this.pattern, o), E = [], t = 0; t < n; t++)
                        E[t] = 0;
                    for (a != -1 && (r = Math.min(this._bitapScore(0, a), r), a = e.lastIndexOf(this.pattern, o + this.patternLen), a != -1 && (r = Math.min(this._bitapScore(0, a), r))), a = -1, m = 1, g = [], u = this.patternLen + n, t = 0; t < this.patternLen; t++) {
                        for (c = 0, l = u; c < l; )
                            this._bitapScore(t, o + l) <= r ? c = l : u = l, l = Math.floor((u - c) / 2 + c);
                        for (u = l, h = Math.max(1, o - l + 1), d = s?n:Math.min(o + l, n) + this.patternLen, f = Array(d + 2), f[d + 1] = (1 << t) - 1, i = d; i >= h; i--)
                            if (v = this.patternAlphabet[e.charAt(i - 1)], v && (E[i - 1] = 1), f[i] = (f[i + 1] << 1 | 1) & v, 0 !== t && (f[i] |= (p[i + 1] | p[i]) << 1 | 1 | p[i + 1]), f[i] & this.matchmask && (m = this._bitapScore(t, i - 1), m <= r)) {
                                if (r = m, a = i - 1, g.push(a), a <= o)
                                    break;
                                h = Math.max(1, 2 * o - a)
                            }
                        if (this._bitapScore(t + 1, o) > r)
                            break;
                        p = f
                    }
                    return _ = this._getMatchedIndices(E), {isMatch: a >= 0, score: 0 === m ? .001 : m, matchedIndices: _}
                }, r.prototype._getMatchedIndices = function (e) {
                    for (var t, i = [], n = -1, s = -1, o = 0, r = e.length; o < r; o++)
                        t = e[o], t && n === -1 ? n = o : t || n === -1 || (s = o - 1, s - n + 1 >= this.options.minMatchCharLength && i.push([n, s]), n = -1);
                    return e[o - 1] && o - 1 - n + 1 >= this.options.minMatchCharLength && i.push([n, o - 1]), i
                }, e.exports = n
            }(this)
        }, function (e, t, i) {
            var n, s;
            !function () {
                "use strict";
                function i() {
                    for (var e = [], t = 0; t < arguments.length; t++) {
                        var n = arguments[t];
                        if (n) {
                            var s = typeof n;
                            if ("string" === s || "number" === s)
                                e.push(n);
                            else if (Array.isArray(n))
                                e.push(i.apply(null, n));
                            else if ("object" === s)
                                for (var r in n)
                                    o.call(n, r) && n[r] && e.push(r)
                        }
                    }
                    return e.join(" ")
                }
                var o = {}.hasOwnProperty;
                "undefined" != typeof e && e.exports ? e.exports = i : (n = [], s = function () {
                    return i
                }.apply(t, n), !(void 0 !== s && (e.exports = s)))
            }()
        }, function (e, t, i) {
            "use strict";
            function n(e) {
                return e && e.__esModule ? e : {default: e}
            }
            function s(e, t) {
                if (!(e instanceof t))
                    throw new TypeError("Cannot call a class as a function")
            }
            Object.defineProperty(t, "__esModule", {value: !0});
            var o = function () {
                function e(e, t) {
                    for (var i = 0; i < t.length; i++) {
                        var n = t[i];
                        n.enumerable = n.enumerable || !1, n.configurable = !0, "value"in n && (n.writable = !0), Object.defineProperty(e, n.key, n)
                    }
                }
                return function (t, i, n) {
                    return i && e(t.prototype, i), n && e(t, n), t
                }
            }(), r = i(5), a = i(26), c = n(a), l = function () {
                function e() {
                    s(this, e), this.store = (0, r.createStore)(c.default, window.devToolsExtension ? window.devToolsExtension() : void 0)
                }
                return o(e, [{key: "getState", value: function () {
                            return this.store.getState()
                        }}, {key: "dispatch", value: function (e) {
                            this.store.dispatch(e)
                        }}, {key: "subscribe", value: function (e) {
                            this.store.subscribe(e)
                        }}, {key: "getItems", value: function () {
                            var e = this.store.getState();
                            return e.items
                        }}, {key: "getItemsFilteredByActive", value: function () {
                            var e = this.getItems(), t = e.filter(function (e) {
                                return e.active === !0
                            }, []);
                            return t
                        }}, {key: "getItemsReducedToValues", value: function () {
                            var e = arguments.length > 0 && void 0 !== arguments[0] ? arguments[0] : this.getItems(), t = e.reduce(function (e, t) {
                                return e.push(t.value), e
                            }, []);
                            return t
                        }}, {key: "getChoices", value: function () {
                            var e = this.store.getState();
                            return e.choices
                        }}, {key: "getChoicesFilteredByActive", value: function () {
                            var e = this.getChoices(), t = e.filter(function (e) {
                                return e.active === !0
                            }, []);
                            return t
                        }}, {key: "getChoicesFilteredBySelectable", value: function () {
                            var e = this.getChoices(), t = e.filter(function (e) {
                                return e.disabled !== !0
                            }, []);
                            return t
                        }}, {key: "getChoiceById", value: function (e) {
                            if (e) {
                                var t = this.getChoicesFilteredByActive(), i = t.find(function (t) {
                                    return t.id === parseInt(e, 10)
                                });
                                return i
                            }
                            return!1
                        }}, {key: "getGroups", value: function () {
                            var e = this.store.getState();
                            return e.groups
                        }}, {key: "getGroupsFilteredByActive", value: function () {
                            var e = this.getGroups(), t = this.getChoices(), i = e.filter(function (e) {
                                var i = e.active === !0 && e.disabled === !1, n = t.some(function (e) {
                                    return e.active === !0 && e.disabled === !1
                                });
                                return i && n
                            }, []);
                            return i
                        }}, {key: "getGroupById", value: function (e) {
                            var t = this.getGroups(), i = t.find(function (t) {
                                return t.id === e
                            });
                            return i
                        }}]), e
            }();
            t.default = l, e.exports = l
        }, function (e, t, i) {
            "use strict";
            function n(e) {
                return e && e.__esModule ? e : {default: e}
            }
            t.__esModule = !0, t.compose = t.applyMiddleware = t.bindActionCreators = t.combineReducers = t.createStore = void 0;
            var s = i(6), o = n(s), r = i(21), a = n(r), c = i(23), l = n(c), u = i(24), h = n(u), d = i(25), f = n(d), p = i(22);
            n(p);
            t.createStore = o.default, t.combineReducers = a.default, t.bindActionCreators = l.default, t.applyMiddleware = h.default, t.compose = f.default
        }, function (e, t, i) {
            "use strict";
            function n(e) {
                return e && e.__esModule ? e : {default: e}
            }
            function s(e, t, i) {
                function n() {
                    g === m && (g = m.slice())
                }
                function o() {
                    return v
                }
                function a(e) {
                    if ("function" != typeof e)
                        throw new Error("Expected listener to be a function.");
                    var t = !0;
                    return n(), g.push(e), function () {
                        if (t) {
                            t = !1, n();
                            var i = g.indexOf(e);
                            g.splice(i, 1)
                        }
                    }
                }
                function u(e) {
                    if (!(0, r.default)(e))
                        throw new Error("Actions must be plain objects. Use custom middleware for async actions.");
                    if ("undefined" == typeof e.type)
                        throw new Error('Actions may not have an undefined "type" property. Have you misspelled a constant?');
                    if (y)
                        throw new Error("Reducers may not dispatch actions.");
                    try {
                        y = !0, v = p(v, e)
                    } finally {
                        y = !1
                    }
                    for (var t = m = g, i = 0; i < t.length; i++)
                        t[i]();
                    return e
                }
                function h(e) {
                    if ("function" != typeof e)
                        throw new Error("Expected the nextReducer to be a function.");
                    p = e, u({type: l.INIT})
                }
                function d() {
                    var e, t = a;
                    return e = {subscribe: function (e) {
                            function i() {
                                e.next && e.next(o())
                            }
                            if ("object" != typeof e)
                                throw new TypeError("Expected the observer to be an object.");
                            i();
                            var n = t(i);
                            return{unsubscribe: n}
                        }}, e[c.default] = function () {
                        return this
                    }, e
                }
                var f;
                if ("function" == typeof t && "undefined" == typeof i && (i = t, t = void 0), "undefined" != typeof i) {
                    if ("function" != typeof i)
                        throw new Error("Expected the enhancer to be a function.");
                    return i(s)(e, t)
                }
                if ("function" != typeof e)
                    throw new Error("Expected the reducer to be a function.");
                var p = e, v = t, m = [], g = m, y = !1;
                return u({type: l.INIT}), f = {dispatch: u, subscribe: a, getState: o, replaceReducer: h}, f[c.default] = d, f
            }
            t.__esModule = !0, t.ActionTypes = void 0, t.default = s;
            var o = i(7), r = n(o), a = i(17), c = n(a), l = t.ActionTypes = {INIT: "@@redux/INIT"}
        }, function (e, t, i) {
            function n(e) {
                if (!r(e) || s(e) != a)
                    return!1;
                var t = o(e);
                if (null === t)
                    return!0;
                var i = h.call(t, "constructor") && t.constructor;
                return"function" == typeof i && i instanceof i && u.call(i) == d
            }
            var s = i(8), o = i(14), r = i(16), a = "[object Object]", c = Function.prototype, l = Object.prototype, u = c.toString, h = l.hasOwnProperty, d = u.call(Object);
            e.exports = n
        }, function (e, t, i) {
            function n(e) {
                return null == e ? void 0 === e ? c : a : l && l in Object(e) ? o(e) : r(e)
            }
            var s = i(9), o = i(12), r = i(13), a = "[object Null]", c = "[object Undefined]", l = s ? s.toStringTag : void 0;
            e.exports = n
        }, function (e, t, i) {
            var n = i(10), s = n.Symbol;
            e.exports = s
        }, function (e, t, i) {
            var n = i(11), s = "object" == typeof self && self && self.Object === Object && self, o = n || s || Function("return this")();
            e.exports = o
        }, function (e, t) {
            (function (t) {
                var i = "object" == typeof t && t && t.Object === Object && t;
                e.exports = i
            }).call(t, function () {
                return this
            }())
        }, function (e, t, i) {
            function n(e) {
                var t = r.call(e, c), i = e[c];
                try {
                    e[c] = void 0;
                    var n = !0
                } catch (e) {
                }
                var s = a.call(e);
                return n && (t ? e[c] = i : delete e[c]), s
            }
            var s = i(9), o = Object.prototype, r = o.hasOwnProperty, a = o.toString, c = s ? s.toStringTag : void 0;
            e.exports = n
        }, function (e, t) {
            function i(e) {
                return s.call(e)
            }
            var n = Object.prototype, s = n.toString;
            e.exports = i
        }, function (e, t, i) {
            var n = i(15), s = n(Object.getPrototypeOf, Object);
            e.exports = s
        }, function (e, t) {
            function i(e, t) {
                return function (i) {
                    return e(t(i))
                }
            }
            e.exports = i
        }, function (e, t) {
            function i(e) {
                return null != e && "object" == typeof e
            }
            e.exports = i
        }, function (e, t, i) {
            e.exports = i(18)
        }, function (e, t, i) {
            (function (e, n) {
                "use strict";
                function s(e) {
                    return e && e.__esModule ? e : {default: e}
                }
                Object.defineProperty(t, "__esModule", {value: !0});
                var o, r = i(20), a = s(r);
                o = "undefined" != typeof self ? self : "undefined" != typeof window ? window : "undefined" != typeof e ? e : n;
                var c = (0, a.default)(o);
                t.default = c
            }).call(t, function () {
                return this
            }(), i(19)(e))
        }, function (e, t) {
            e.exports = function (e) {
                return e.webpackPolyfill || (e.deprecate = function () {}, e.paths = [], e.children = [], e.webpackPolyfill = 1), e
            }
        }, function (e, t) {
            "use strict";
            function i(e) {
                var t, i = e.Symbol;
                return"function" == typeof i ? i.observable ? t = i.observable : (t = i("observable"), i.observable = t) : t = "@@observable", t
            }
            Object.defineProperty(t, "__esModule", {value: !0}), t.default = i
        }, function (e, t, i) {
            "use strict";
            function n(e) {
                return e && e.__esModule ? e : {default: e}
            }
            function s(e, t) {
                var i = t && t.type, n = i && '"' + i.toString() + '"' || "an action";
                return"Given action " + n + ', reducer "' + e + '" returned undefined. To ignore an action, you must explicitly return the previous state.'
            }
            function o(e) {
                Object.keys(e).forEach(function (t) {
                    var i = e[t], n = i(void 0, {type: a.ActionTypes.INIT});
                    if ("undefined" == typeof n)
                        throw new Error('Reducer "' + t + '" returned undefined during initialization. If the state passed to the reducer is undefined, you must explicitly return the initial state. The initial state may not be undefined.');
                    var s = "@@redux/PROBE_UNKNOWN_ACTION_" + Math.random().toString(36).substring(7).split("").join(".");
                    if ("undefined" == typeof i(void 0, {type: s}))
                        throw new Error('Reducer "' + t + '" returned undefined when probed with a random type. ' + ("Don't try to handle " + a.ActionTypes.INIT + ' or other actions in "redux/*" ') + "namespace. They are considered private. Instead, you must return the current state for any unknown actions, unless it is undefined, in which case you must return the initial state, regardless of the action type. The initial state may not be undefined.")
                })
            }
            function r(e) {
                for (var t = Object.keys(e), i = {}, n = 0; n < t.length; n++) {
                    var r = t[n];
                    "function" == typeof e[r] && (i[r] = e[r])
                }
                var a, c = Object.keys(i);
                try {
                    o(i)
                } catch (e) {
                    a = e
                }
                return function () {
                    var e = arguments.length <= 0 || void 0 === arguments[0] ? {} : arguments[0], t = arguments[1];
                    if (a)
                        throw a;
                    for (var n = !1, o = {}, r = 0; r < c.length; r++) {
                        var l = c[r], u = i[l], h = e[l], d = u(h, t);
                        if ("undefined" == typeof d) {
                            var f = s(l, t);
                            throw new Error(f)
                        }
                        o[l] = d, n = n || d !== h
                    }
                    return n ? o : e
                }
            }
            t.__esModule = !0, t.default = r;
            var a = i(6), c = i(7), l = (n(c), i(22));
            n(l)
        }, function (e, t) {
            "use strict";
            function i(e) {
                "undefined" != typeof console && "function" == typeof console.error && console.error(e);
                try {
                    throw new Error(e)
                } catch (e) {
                }
            }
            t.__esModule = !0, t.default = i
        }, function (e, t) {
            "use strict";
            function i(e, t) {
                return function () {
                    return t(e.apply(void 0, arguments))
                }
            }
            function n(e, t) {
                if ("function" == typeof e)
                    return i(e, t);
                if ("object" != typeof e || null === e)
                    throw new Error("bindActionCreators expected an object or a function, instead received " + (null === e ? "null" : typeof e) + '. Did you write "import ActionCreators from" instead of "import * as ActionCreators from"?');
                for (var n = Object.keys(e), s = {}, o = 0; o < n.length; o++) {
                    var r = n[o], a = e[r];
                    "function" == typeof a && (s[r] = i(a, t))
                }
                return s
            }
            t.__esModule = !0, t.default = n
        }, function (e, t, i) {
            "use strict";
            function n(e) {
                return e && e.__esModule ? e : {default: e}
            }
            function s() {
                for (var e = arguments.length, t = Array(e), i = 0; i < e; i++)
                    t[i] = arguments[i];
                return function (e) {
                    return function (i, n, s) {
                        var r = e(i, n, s), c = r.dispatch, l = [], u = {getState: r.getState, dispatch: function (e) {
                                return c(e)
                            }};
                        return l = t.map(function (e) {
                            return e(u)
                        }), c = a.default.apply(void 0, l)(r.dispatch), o({}, r, {dispatch: c})
                    }
                }
            }
            t.__esModule = !0;
            var o = Object.assign || function (e) {
                for (var t = 1; t < arguments.length; t++) {
                    var i = arguments[t];
                    for (var n in i)
                        Object.prototype.hasOwnProperty.call(i, n) && (e[n] = i[n])
                }
                return e
            };
            t.default = s;
            var r = i(25), a = n(r)
        }, function (e, t) {
            "use strict";
            function i() {
                for (var e = arguments.length, t = Array(e), i = 0; i < e; i++)
                    t[i] = arguments[i];
                if (0 === t.length)
                    return function (e) {
                        return e
                    };
                if (1 === t.length)
                    return t[0];
                var n = t[t.length - 1], s = t.slice(0, -1);
                return function () {
                    return s.reduceRight(function (e, t) {
                        return t(e)
                    }, n.apply(void 0, arguments))
                }
            }
            t.__esModule = !0, t.default = i
        }, function (e, t, i) {
            "use strict";
            function n(e) {
                return e && e.__esModule ? e : {default: e}
            }
            Object.defineProperty(t, "__esModule", {value: !0});
            var s = i(5), o = i(27), r = n(o), a = i(28), c = n(a), l = i(29), u = n(l), h = (0, s.combineReducers)({items: r.default, groups: c.default, choices: u.default}), d = function (e, t) {
                var i = e;
                return"CLEAR_ALL" === t.type && (i = void 0), h(i, t)
            };
            t.default = d
        }, function (e, t) {
            "use strict";
            function i(e) {
                if (Array.isArray(e)) {
                    for (var t = 0, i = Array(e.length); t < e.length; t++)
                        i[t] = e[t];
                    return i
                }
                return Array.from(e)
            }
            Object.defineProperty(t, "__esModule", {value: !0});
            var n = function () {
                var e = arguments.length > 0 && void 0 !== arguments[0] ? arguments[0] : [], t = arguments[1];
                switch (t.type) {
                    case"ADD_ITEM":
                        var n = [].concat(i(e), [{id: t.id, choiceId: t.choiceId, groupId: t.groupId, value: t.value, label: t.label, active: !0, highlighted: !1, customProperties: t.customProperties, keyCode: null}]);
                        return n.map(function (e) {
                            return e.highlighted && (e.highlighted = !1), e
                        });
                    case"REMOVE_ITEM":
                        return e.map(function (e) {
                            return e.id === t.id && (e.active = !1), e
                        });
                    case"HIGHLIGHT_ITEM":
                        return e.map(function (e) {
                            return e.id === t.id && (e.highlighted = t.highlighted), e
                        });
                    default:
                        return e
                }
            };
            t.default = n
        }, function (e, t) {
            "use strict";
            function i(e) {
                if (Array.isArray(e)) {
                    for (var t = 0, i = Array(e.length); t < e.length; t++)
                        i[t] = e[t];
                    return i
                }
                return Array.from(e)
            }
            Object.defineProperty(t, "__esModule", {value: !0});
            var n = function () {
                var e = arguments.length > 0 && void 0 !== arguments[0] ? arguments[0] : [], t = arguments[1];
                switch (t.type) {
                    case"ADD_GROUP":
                        return[].concat(i(e), [{id: t.id, value: t.value, active: t.active, disabled: t.disabled}]);
                    case"CLEAR_CHOICES":
                        return e.groups = [];
                    default:
                        return e
                }
            };
            t.default = n
        }, function (e, t) {
            "use strict";
            function i(e) {
                if (Array.isArray(e)) {
                    for (var t = 0, i = Array(e.length); t < e.length; t++)
                        i[t] = e[t];
                    return i
                }
                return Array.from(e)
            }
            Object.defineProperty(t, "__esModule", {value: !0});
            var n = function () {
                var e = arguments.length > 0 && void 0 !== arguments[0] ? arguments[0] : [], t = arguments[1];
                switch (t.type) {
                    case"ADD_CHOICE":
                        return[].concat(i(e), [{id: t.id, elementId: t.elementId, groupId: t.groupId, value: t.value, label: t.label || t.value, disabled: t.disabled || !1, selected: !1, active: !0, score: 9999, customProperties: t.customProperties, keyCode: null}]);
                    case"ADD_ITEM":
                        var n = e;
                        return t.activateOptions && (n = e.map(function (e) {
                            return e.active = t.active, e
                        })), t.choiceId > -1 && (n = e.map(function (e) {
                            return e.id === parseInt(t.choiceId, 10) && (e.selected = !0), e
                        })), n;
                    case"REMOVE_ITEM":
                        return t.choiceId > -1 ? e.map(function (e) {
                            return e.id === parseInt(t.choiceId, 10) && (e.selected = !1), e
                        }) : e;
                    case"FILTER_CHOICES":
                        var s = t.results, o = e.map(function (e) {
                            return e.active = s.some(function (t) {
                                return t.item.id === e.id && (e.score = t.score, !0)
                            }), e
                        });
                        return o;
                    case"ACTIVATE_CHOICES":
                        return e.map(function (e) {
                            return e.active = t.active, e
                        });
                    case"CLEAR_CHOICES":
                        return e.choices = [];
                    default:
                        return e
                }
            };
            t.default = n
        }, function (e, t) {
            "use strict";
            Object.defineProperty(t, "__esModule", {value: !0});
            t.addItem = function (e, t, i, n, s, o, r) {
                return{type: "ADD_ITEM", value: e, label: t, id: i, choiceId: n, groupId: s, customProperties: o, keyCode: r}
            }, t.removeItem = function (e, t) {
                return{type: "REMOVE_ITEM", id: e, choiceId: t}
            }, t.highlightItem = function (e, t) {
                return{type: "HIGHLIGHT_ITEM", id: e, highlighted: t}
            }, t.addChoice = function (e, t, i, n, s, o, r, a) {
                return{type: "ADD_CHOICE", value: e, label: t, id: i, groupId: n, disabled: s, elementId: o, customProperties: r, keyCode: a}
            }, t.filterChoices = function (e) {
                return{type: "FILTER_CHOICES", results: e}
            }, t.activateChoices = function () {
                var e = !(arguments.length > 0 && void 0 !== arguments[0]) || arguments[0];
                return{type: "ACTIVATE_CHOICES", active: e}
            }, t.clearChoices = function () {
                return{type: "CLEAR_CHOICES"}
            }, t.addGroup = function (e, t, i, n) {
                return{type: "ADD_GROUP", value: e, id: t, active: i, disabled: n}
            }, t.clearAll = function () {
                return{type: "CLEAR_ALL"}
            }
        }, function (e, t) {
            "use strict";
            Object.defineProperty(t, "__esModule", {value: !0});
            var i = "function" == typeof Symbol && "symbol" == typeof Symbol.iterator ? function (e) {
                return typeof e
            } : function (e) {
                return e && "function" == typeof Symbol && e.constructor === Symbol && e !== Symbol.prototype ? "symbol" : typeof e
            }, n = (t.capitalise = function (e) {
                return e.replace(/\w\S*/g, function (e) {
                    return e.charAt(0).toUpperCase() + e.substr(1).toLowerCase()
                })
            }, t.generateChars = function (e) {
                for (var t = "", i = 0; i < e; i++) {
                    var n = a(0, 36);
                    t += n.toString(36)
                }
                return t
            }), s = (t.generateId = function (e, t) {
                var i = e.id || e.name && e.name + "-" + n(2) || n(4);
                return i = i.replace(/(:|\.|\[|\]|,)/g, ""), i = t + i
            }, t.getType = function (e) {
                return Object.prototype.toString.call(e).slice(8, -1)
            }), o = t.isType = function (e, t) {
                var i = s(t);
                return void 0 !== t && null !== t && i === e
            }, r = (t.isNode = function (e) {
                return"object" === ("undefined" == typeof Node ? "undefined" : i(Node)) ? e instanceof Node : e && "object" === ("undefined" == typeof e ? "undefined" : i(e)) && "number" == typeof e.nodeType && "string" == typeof e.nodeName
            }, t.isElement = function (e) {
                return"object" === ("undefined" == typeof HTMLElement ? "undefined" : i(HTMLElement)) ? e instanceof HTMLElement : e && "object" === ("undefined" == typeof e ? "undefined" : i(e)) && null !== e && 1 === e.nodeType && "string" == typeof e.nodeName
            }, t.extend = function e() {
                for (var t = {}, i = arguments.length, n = function (i) {
                    for (var n in i)
                        Object.prototype.hasOwnProperty.call(i, n) && (o("Object", i[n]) ? t[n] = e(!0, t[n], i[n]) : t[n] = i[n])
                }, s = 0; s < i; s++) {
                    var r = arguments[s];
                    o("Object", r) && n(r)
                }
                return t
            }, t.whichTransitionEvent = function () {
                var e, t = document.createElement("fakeelement"), i = {transition: "transitionend", OTransition: "oTransitionEnd", MozTransition: "transitionend", WebkitTransition: "webkitTransitionEnd"};
                for (e in i)
                    if (void 0 !== t.style[e])
                        return i[e]
            }, t.whichAnimationEvent = function () {
                var e, t = document.createElement("fakeelement"), i = {animation: "animationend", OAnimation: "oAnimationEnd", MozAnimation: "animationend", WebkitAnimation: "webkitAnimationEnd"};
                for (e in i)
                    if (void 0 !== t.style[e])
                        return i[e]
            }), a = (t.getParentsUntil = function (e, t, i) {
                for (var n = []; e && e !== document; e = e.parentNode) {
                    if (t) {
                        var s = t.charAt(0);
                        if ("." === s && e.classList.contains(t.substr(1)))
                            break;
                        if ("#" === s && e.id === t.substr(1))
                            break;
                        if ("[" === s && e.hasAttribute(t.substr(1, t.length - 1)))
                            break;
                        if (e.tagName.toLowerCase() === t)
                            break
                    }
                    if (i) {
                        var o = i.charAt(0);
                        "." === o && e.classList.contains(i.substr(1)) && n.push(e), "#" === o && e.id === i.substr(1) && n.push(e), "[" === o && e.hasAttribute(i.substr(1, i.length - 1)) && n.push(e), e.tagName.toLowerCase() === i && n.push(e)
                    } else
                        n.push(e)
                }
                return 0 === n.length ? null : n
            }, t.wrap = function (e, t) {
                return t = t || document.createElement("div"), e.nextSibling ? e.parentNode.insertBefore(t, e.nextSibling) : e.parentNode.appendChild(t), t.appendChild(e)
            }, t.getSiblings = function (e) {
                for (var t = [], i = e.parentNode.firstChild; i; i = i.nextSibling)
                    1 === i.nodeType && i !== e && t.push(i);
                return t
            }, t.findAncestor = function (e, t) {
                for (; (e = e.parentElement) && !e.classList.contains(t); )
                    ;
                return e
            }, t.findAncestorByAttrName = function (e, t) {
                for (var i = e; i; ) {
                    if (i.hasAttribute(t))
                        return i;
                    i = i.parentElement
                }
                return null
            }, t.debounce = function (e, t, i) {
                var n;
                return function () {
                    var s = this, o = arguments, r = function () {
                        n = null, i || e.apply(s, o)
                    }, a = i && !n;
                    clearTimeout(n), n = setTimeout(r, t), a && e.apply(s, o)
                }
            }, t.getElemDistance = function (e) {
                var t = 0;
                if (e.offsetParent)
                    do
                        t += e.offsetTop, e = e.offsetParent;
                    while (e);
                return t >= 0 ? t : 0
            }, t.getElementOffset = function (e, t) {
                var i = t;
                return i > 1 && (i = 1),
                        i > 0 && (i = 0), Math.max(e.offsetHeight * i)
            }, t.getAdjacentEl = function (e, t) {
                var i = arguments.length > 2 && void 0 !== arguments[2] ? arguments[2] : 1;
                if (e && t) {
                    var n = e.parentNode.parentNode, s = Array.from(n.querySelectorAll(t)), o = s.indexOf(e), r = i > 0 ? 1 : -1;
                    return s[o + r]
                }
            }, t.getScrollPosition = function (e) {
                return"bottom" === e ? Math.max((window.scrollY || window.pageYOffset) + (window.innerHeight || document.documentElement.clientHeight)) : window.scrollY || window.pageYOffset
            }, t.isInView = function (e, t, i) {
                return this.getScrollPosition(t) > this.getElemDistance(e) + this.getElementOffset(e, i)
            }, t.isScrolledIntoView = function (e, t) {
                var i = arguments.length > 2 && void 0 !== arguments[2] ? arguments[2] : 1;
                if (e) {
                    var n = void 0;
                    return n = i > 0 ? t.scrollTop + t.offsetHeight >= e.offsetTop + e.offsetHeight : e.offsetTop >= t.scrollTop
                }
            }, t.stripHTML = function (e) {
                var t = document.createElement("DIV");
                return t.innerHTML = e, t.textContent || t.innerText || ""
            }, t.addAnimation = function (e, t) {
                var i = r(), n = function n() {
                    e.classList.remove(t), e.removeEventListener(i, n, !1)
                };
                e.classList.add(t), e.addEventListener(i, n, !1)
            }, t.getRandomNumber = function (e, t) {
                return Math.floor(Math.random() * (t - e) + e)
            }), c = t.strToEl = function () {
                var e = document.createElement("div");
                return function (t) {
                    var i = t.trim(), n = void 0;
                    for (e.innerHTML = i, n = e.children[0]; e.firstChild; )
                        e.removeChild(e.firstChild);
                    return n
                }
            }();
            t.getWidthOfInput = function (e) {
                var t = e.value || e.placeholder, i = e.offsetWidth;
                if (t) {
                    var n = c("<span>" + t + "</span>");
                    n.style.position = "absolute", n.style.padding = "0", n.style.top = "-9999px", n.style.left = "-9999px", n.style.width = "auto", n.style.whiteSpace = "pre", document.body.appendChild(n), t && n.offsetWidth !== e.offsetWidth && (i = n.offsetWidth + 4), document.body.removeChild(n)
                }
                return i + "px"
            }, t.sortByAlpha = function (e, t) {
                var i = (e.label || e.value).toLowerCase(), n = (t.label || t.value).toLowerCase();
                return i < n ? -1 : i > n ? 1 : 0
            }, t.sortByScore = function (e, t) {
                return e.score - t.score
            }, t.triggerEvent = function (e, t) {
                var i = arguments.length > 2 && void 0 !== arguments[2] ? arguments[2] : null, n = new CustomEvent(t, {detail: i, bubbles: !0, cancelable: !0});
                return e.dispatchEvent(n)
            }
        }, function (e, t) {
            "use strict";
            !function () {
                function e(e, t) {
                    t = t || {bubbles: !1, cancelable: !1, detail: void 0};
                    var i = document.createEvent("CustomEvent");
                    return i.initCustomEvent(e, t.bubbles, t.cancelable, t.detail), i
                }
                Array.from || (Array.from = function () {
                    var e = Object.prototype.toString, t = function (t) {
                        return"function" == typeof t || "[object Function]" === e.call(t)
                    }, i = function (e) {
                        var t = Number(e);
                        return isNaN(t) ? 0 : 0 !== t && isFinite(t) ? (t > 0 ? 1 : -1) * Math.floor(Math.abs(t)) : t
                    }, n = Math.pow(2, 53) - 1, s = function (e) {
                        var t = i(e);
                        return Math.min(Math.max(t, 0), n)
                    };
                    return function (e) {
                        var i = this, n = Object(e);
                        if (null == e)
                            throw new TypeError("Array.from requires an array-like object - not null or undefined");
                        var o, r = arguments.length > 1 ? arguments[1] : void 0;
                        if ("undefined" != typeof r) {
                            if (!t(r))
                                throw new TypeError("Array.from: when provided, the second argument must be a function");
                            arguments.length > 2 && (o = arguments[2])
                        }
                        for (var a, c = s(n.length), l = t(i) ? Object(new i(c)) : new Array(c), u = 0; u < c; )
                            a = n[u], r ? l[u] = "undefined" == typeof o ? r(a, u) : r.call(o, a, u) : l[u] = a, u += 1;
                        return l.length = c, l
                    }
                }()), Array.prototype.find || (Array.prototype.find = function (e) {
                    if (null == this)
                        throw new TypeError("Array.prototype.find called on null or undefined");
                    if ("function" != typeof e)
                        throw new TypeError("predicate must be a function");
                    for (var t, i = Object(this), n = i.length >>> 0, s = arguments[1], o = 0; o < n; o++)
                        if (t = i[o], e.call(s, t, o, i))
                            return t
                }), e.prototype = window.Event.prototype, window.CustomEvent = e
            }()
        }])
});


