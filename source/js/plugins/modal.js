class Modal {
    /**
     * Initialize a new instance of Modal with the modal element.
     *
     * @param  {DOMNode} The modal being initialized
     * @return void
     */
    constructor(modalElement) {
        let scope = this

        scope.modal = modalElement
        scope.overlay = document.querySelector('[data-ref="modalOverlay"]')
        scope.close = document.querySelector('[data-ref="modalClose"]')
        scope.disabledClass = '-modal-disabled'

        scope._bindEvents()
    }

    /**
     * Reveals the modal and overlay.
     *
     * @return void
     */
    show() {
        let scope = this

        // TODO: Remove this in future projects; this is Texas-specific.
        if (document.querySelector('.header--fixed')) {
            document.querySelector('.header--fixed').classList.add('header--is-below-modal')
        }

        scope.modal.classList.remove(scope.disabledClass)
        scope.overlay.classList.remove(scope.disabledClass)
        scope.close.classList.remove(scope.disabledClass)
    }

    /**
     * Hides the modal and overlay.
     *
     * @return void
     */
    hide() {
        let scope = this

        // TODO: Remove this in future projects; this is Texas-specific.
        if (document.querySelector('.header--fixed')) {
            document.querySelector('.header--fixed').classList.add('header--is-below-modal')
        }

        scope.modal.classList.add(scope.disabledClass)
        scope.overlay.classList.add(scope.disabledClass)
        scope.close.classList.add(scope.disabledClass)
    }

    /**
     * Toggles the modal and overlay.
     *
     * @return void
     */
    toggle() {
        let scope = this

        scope.modal.classList.toggle(scope.disabledClass)
        scope.overlay.classList.toggle(scope.disabledClass)
        scope.close.classList.toggle(scope.disabledClass)
    }

    _bindEvents() {
        let scope = this

        scope.close.addEventListener('click', () => {
            scope.hide()
        })
    }
}

export default Modal
