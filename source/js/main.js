import 'babel-polyfill'
import 'object-assign-polyfill'

import $ from './framework/$'
import $router from './framework/Router'
import common from './controllers/common'
import home from './controllers/home'
import menu from './controllers/menu'
import shop from './controllers/shop'
import cards from './controllers/cards'
import cart from './controllers/cart'
import locations from './controllers/locations'
import locationsDetail from './controllers/locations-detail'
import eclub from './controllers/eclub'
import about from './controllers/about'
import groupDining from './controllers/group-dining'
import promotions from './controllers/promotions'
import contact from './controllers/contact'
import checkout from './controllers/checkout'
import balance from './controllers/balance'
import leasing from './controllers/leasing'

$router.map([
    {
        path: '.*',
        handler: common
    },
    {
        path: '$home',
        handler: home
    },
    {
        path: '^\/menu$',
        handler: menu
    },
    {
        path: 'menu\/.*$',
        handler: menu
    },
    {
        path: 'promotions/promotion-list-headline',
        handler: promotions
    },
    {
        path: 'shop\/.*\/.*$',
        handler: shop
    },
    {
        path: 'shop\/cards\/.*$',
        handler: cards
    },
    {
        path: 'cart',
        handler: cart
    },
    {
        path: 'locations$',
        handler: locations
    },
    {
        path: 'locations\/.*$',
        handler: locationsDetail
    },
    {
        path: 'eclub',
        handler: eclub
    },
    {
        path: 'about',
        handler: about
    },
    {
        path: 'group-dining$',
        handler: groupDining
    },
    {
        path: 'leasing-expansion$',
        handler: leasing
    },
    {
        path: 'contact',
        handler: contact
    },
    {
        path: 'checkout',
        handler: checkout
    },
    {
        path: 'balance',
        handler: balance
    }
])

$.ready($router)
