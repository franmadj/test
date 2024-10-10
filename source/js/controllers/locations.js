import $ from '../framework/$'
import serialize from '../plugins/serialize'
import axios from '../plugins/axios'

let mapState = {
    currentMarker: null,
    infoBox: null,
    lat: null,
    lng: null,
    map: null,
    markers: [],
}

function init() {

    $(':resultsResetBtn').hide()

    mapState.lat = parseFloat($('meta[name="lat"]').attr('value'))
    mapState.lng = parseFloat($('meta[name="lng"]').attr('value'))

    loadMap()

    bindEvents()

    bindFinderForm()

    moveLocationBlocks()

    axios.defaults.headers.post['Content-Type'] = 'application/x-www-form-urlencoded; charset=UTF-8;'

    axios.defaults.headers.post['X-Requested-With'] = 'XMLHttpRequest'
}

function bindEvents() {
    window.addEventListener('resize', moveLocationBlocks)

    $(':filterMarkers').on('click', (e, el) => {
        let markerType = el.getAttribute('data-type'),
            disabledClass = 'c-locations__item--disabled',
            hiddenClass = 'c-locations__item--hidden',
            activeClass = 'u-finder__option--selected'

        // DEV: Don't allow more toggling until Google Maps adds all markers.
        if ($(el).hasClass('js-disable-click') || $(el).hasClass(activeClass)) {
            return
        }

        $(':filterMarkers').each(function(el) {
            $(el).addClass('js-disable-click')
        })

        $(el).addClass(activeClass).siblings().removeClass(activeClass)

        if (markerType == 'all') {
            $('.c-locations__item--disabled').removeClass(disabledClass)
        } else {
            mapState.map.setZoom(3);

            mapState.map.setCenter({
                lat: mapState.lat,
                lng: mapState.lng
            });

            $(':location').each((el) => {
                if ($(el).data('type') !== markerType) {
                    $(el).addClass(disabledClass)
                } else {
                    $(el).removeClass(disabledClass).removeClass(hiddenClass)
                }
            })
        }

        updateLocationData(false, function() {
            $(':filterMarkers').removeClass('js-disable-click')
        })

    })

    $(':jumpToRegion').on('click', (e, el) => {

        var lat = el.getAttribute('data-lat')
        var lng = el.getAttribute('data-lng')
        var zoom = el.getAttribute('data-zoom')

        mapState.map.setZoom(parseInt(zoom))

        mapState.map.setCenter({
            lat: parseInt(lat),
            lng: parseInt(lng)
        })

    })

    window.addEventListener('resize', () => {
        if (window.innerWidth < 768) {
            mapState.map.setOptions({ zoomControlOptions: { position: google.maps.ControlPosition.LEFT_TOP } });
        } else {
            mapState.map.setOptions({ zoomControlOptions: { position: google.maps.ControlPosition.LEFT_CENTER } });
        }
    })

    $(':revealLocations').on('click', revealLocations)
}

function revealLocations(e, el) {
    let disabledLocations = $('[data-ref="location"].c-locations__item--hidden'),
        nextFiveLocations = disabledLocations.els.slice(0, 5),
        disabledClass = 'c-locations__item--disabled';

    $(nextFiveLocations).each((el) => {
        $(el).removeClass('c-locations__item--hidden')
    })

    if (nextFiveLocations.length < 5) {
        $(el).addClass(disabledClass)
    }
}

function loadMap() {
    let googleMapsScript = document.createElement('script'),
        infoBoxScript = document.createElement('script')

    infoBoxScript.setAttribute('src', '/assets/js/vendor/infoBox.js')

    var bottomsUp = 10

    if (window.innerWidth < 768)
        var bottomsUp = 35

    infoBoxScript.addEventListener('load', () => {
        let options = {
            alignBottom: true,
            boxClass: 'c-pane',
            closeBoxURL: '',
            content: '',
            disableAutoPan: false,
            enableEventPropagation: false,
            infoBoxClearance: new google.maps.Size(1, 1),
            isHidden: false,
            pane: "floatPane",
            pixelOffset: new google.maps.Size(-130, -bottomsUp),
            zIndex: null
        }

        mapState.infoBox = new InfoBox(options)

    })

    googleMapsScript.setAttribute('src', $('meta[name="apiKey"]')[0].getAttribute('value'))

    googleMapsScript.addEventListener('load', () => {
        mapState.map = new google.maps.Map(document.getElementById('map'), {
            center: {
                lat: mapState.lat,
                lng: mapState.lng
            },
            zoom: 5,            
            minZoom : 3,
            maxZoom : 10,
            mapTypeControl: false,
            zoomControl: true,
            zoomControlOptions: {
            position: google.maps.ControlPosition.LEFT_CENTER
          },
          scaleControl: false,
          streetViewControl: false,
          fullscreenControl: false,
            styles: [
                {
                    "elementType": "geometry",
                    "stylers": [
                        {
                            "color": "#ebe3cd"
                        }
                    ]
                },
                {
                    "elementType": "labels.text.fill",
                    "stylers": [
                        {
                            "color": "#523735"
                        }
                    ]
                },
                {
                    "elementType": "labels.text.stroke",
                    "stylers": [
                        {
                            "color": "#f5f1e6"
                        }
                    ]
                },
                {
                    "featureType": "administrative",
                    "elementType": "geometry",
                    "stylers": [
                        {
                            "visibility": "off"
                        }
                    ]
                },
                {
                    "featureType": "administrative",
                    "elementType": "geometry.stroke",
                    "stylers": [
                        {
                            "color": "#c9b2a6"
                        }
                    ]
                },
                {
                    "featureType": "administrative.country",
                    "elementType": "geometry.stroke",
                    "stylers": [
                        {
                            "color": "#d29a52"
                        },
                        {
                            "visibility": "on"
                        }
                    ]
                },
                {
                    "featureType": "administrative.land_parcel",
                    "stylers": [
                        {
                            "visibility": "off"
                        }
                    ]
                },
                {
                    "featureType": "administrative.land_parcel",
                    "elementType": "geometry.stroke",
                    "stylers": [
                        {
                            "color": "#dcd2be"
                        }
                    ]
                },
                {
                    "featureType": "administrative.land_parcel",
                    "elementType": "labels.text.fill",
                    "stylers": [
                        {
                            "color": "#ae9e90"
                        }
                    ]
                },
                {
                    "featureType": "administrative.neighborhood",
                    "stylers": [
                        {
                            "visibility": "off"
                        }
                    ]
                },
                {
                    "featureType": "administrative.province",
                    "elementType": "geometry.stroke",
                    "stylers": [
                        {
                            "color": "#d19137"
                        },
                        {
                            "visibility": "on"
                        },
                        {
                            "weight": 1
                        }
                    ]
                },
                {
                    "featureType": "landscape.natural",
                    "elementType": "geometry",
                    "stylers": [
                        {
                            "color": "#F7F2E9"
                        }
                    ]
                },
                {
                    "featureType": "poi",
                    "stylers": [
                        {
                            "visibility": "off"
                        }
                    ]
                },
                {
                    "featureType": "poi",
                    "elementType": "geometry",
                    "stylers": [
                        {
                            "color": "#dfd2ae"
                        }
                    ]
                },
                {
                    "featureType": "poi",
                    "elementType": "labels.text.fill",
                    "stylers": [
                        {
                            "color": "#93817c"
                        }
                    ]
                },
                {
                    "featureType": "poi.park",
                    "elementType": "geometry.fill",
                    "stylers": [
                        {
                            "color": "#a5b076"
                        }
                    ]
                },
                {
                    "featureType": "poi.park",
                    "elementType": "labels.text.fill",
                    "stylers": [
                        {
                            "color": "#447530"
                        }
                    ]
                },
                {
                    "featureType": "road",
                    "elementType": "geometry",
                    "stylers": [
                        {
                            "color": "#f5f1e6"
                        },
                        {
                            "visibility": "off"
                        },
                        {
                            "weight": 2
                        }
                    ]
                },
                {
                    "featureType": "road",
                    "elementType": "labels",
                    "stylers": [
                        {
                            "visibility": "off"
                        }
                    ]
                },
                {
                    "featureType": "road",
                    "elementType": "labels.icon",
                    "stylers": [
                        {
                            "visibility": "off"
                        }
                    ]
                },
                {
                    "featureType": "road.arterial",
                    "elementType": "geometry",
                    "stylers": [
                        {
                            "color": "#fdfcf8"
                        }
                    ]
                },
                {
                    "featureType": "road.highway",
                    "elementType": "geometry",
                    "stylers": [
                        {
                            "color": "#D29136"
                        }
                    ]
                },
                {
                    "featureType": "road.highway",
                    "elementType": "geometry.stroke",
                    "stylers": [
                        {
                            "color": "#D29136"
                        },
                        {
                            "visibility": "off"
                        }
                    ]
                },
                {
                    "featureType": "road.highway.controlled_access",
                    "elementType": "geometry",
                    "stylers": [
                        {
                            "color": "#D29136"
                        }
                    ]
                },
                {
                    "featureType": "road.highway.controlled_access",
                    "elementType": "geometry.stroke",
                    "stylers": [
                        {
                            "color": "#D29136"
                        }
                    ]
                },
                {
                    "featureType": "road.local",
                    "stylers": [
                        {
                            "color": "#d19037"
                        }
                    ]
                },
                {
                    "featureType": "road.local",
                    "elementType": "labels.text.fill",
                    "stylers": [
                        {
                            "color": "#806b63"
                        }
                    ]
                },
                {
                    "featureType": "transit",
                    "stylers": [
                        {
                            "visibility": "off"
                        }
                    ]
                },
                {
                    "featureType": "transit.line",
                    "elementType": "geometry",
                    "stylers": [
                        {
                            "color": "#dfd2ae"
                        }
                    ]
                },
                {
                    "featureType": "transit.line",
                    "elementType": "labels.text.fill",
                    "stylers": [
                        {
                            "color": "#8f7d77"
                        }
                    ]
                },
                {
                    "featureType": "transit.line",
                    "elementType": "labels.text.stroke",
                    "stylers": [
                        {
                            "color": "#ebe3cd"
                        }
                    ]
                },
                {
                    "featureType": "transit.station",
                    "elementType": "geometry",
                    "stylers": [
                        {
                            "color": "#dfd2ae"
                        }
                    ]
                },
                {
                    "featureType": "water",
                    "elementType": "geometry.fill",
                    "stylers": [
                        {
                            "color": "#E4DCD0"
                        }
                    ]
                },
                {
                    "featureType": "water",
                    "elementType": "labels.text",
                    "stylers": [
                        {
                            "visibility": "off"
                        }
                    ]
                },
                {
                    "featureType": "water",
                    "elementType": "labels.text.fill",
                    "stylers": [
                        {
                            "color": "#92998d"
                        }
                    ]
                }
            ]
        })

        if (window.innerWidth < 768) {
            mapState.map.setOptions({ zoomControlOptions: { position: google.maps.ControlPosition.LEFT_TOP } });
        } else {
            mapState.map.setOptions({ zoomControlOptions: { position: google.maps.ControlPosition.LEFT_CENTER } });
        }

        mapState.map.addListener('tilesloaded', function () {
            //document.querySelector('iframe').setAttribute('title', 'Texas de Brazil Locations')
        })
        
        if ($(':address')[0].value && $('[data-type="distanceParam"]')[0].value) {
            fetchLocations($(':fetchLocations')[0])
        } else {
            updateLocationData()
        }

        document.body.appendChild(infoBoxScript)
    })

    document.body.appendChild(googleMapsScript)
}

function updateLocationData(isSubmit = false, callback) {
    let index = 0
    
    var getGoogleClusterInlineSvg = function (color) {
        var encoded = window.btoa('<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="-100 -100 200 200"><defs><g id="a" transform="rotate(45)"><path d="M0 47A47 47 0 0 0 47 0L62 0A62 62 0 0 1 0 62Z" fill-opacity="0.7"/><path d="M0 67A67 67 0 0 0 67 0L81 0A81 81 0 0 1 0 81Z" fill-opacity="0.5"/><path d="M0 86A86 86 0 0 0 86 0L100 0A100 100 0 0 1 0 100Z" fill-opacity="0.3"/></g></defs><g fill="' + color + '"><circle r="42"/><use xlink:href="#a"/><g transform="rotate(120)"><use xlink:href="#a"/></g><g transform="rotate(240)"><use xlink:href="#a"/></g></g></svg>');

        return ('data:image/svg+xml;base64,' + encoded);
    };

    let clusterStyles = [
      {
        height: 40,
        width: 40,
        textColor: 'black',
        url: getGoogleClusterInlineSvg('#6e181e'),
        textColor: 'white',
        textSize: 12
      },
     {
        height: 50,
        width: 50,
        textColor: 'black',
        url: getGoogleClusterInlineSvg('#6e181e'),
        textColor: 'white',
        textSize: 14
      },
     {
        height: 60,
        width: 60,
        textColor: 'black',
        url: getGoogleClusterInlineSvg('#6e181e'),
        textColor: 'white',
        textSize: 16
      }
    ];

    let mcOptions = {
        //zoomOnClick: false,
        gridSize: 50,
        styles: clusterStyles,
        maxZoom: 9
    };


    $(mapState.markers).each((marker) => {
        marker.setMap(null)
        mapState.markerCluster.removeMarker(marker)
    })

    mapState.markers = []
    mapState.markerCluster = []
    mapState.markerCluster = new MarkerClusterer(mapState.map, [],mcOptions)

    let countMarkers = 0

    let infowindow = new google.maps.InfoWindow({
        pixelOffset: new google.maps.Size(0, -29)
    });

    // DEV: The strange class targeting is accounting for the case where a user
    // has selected only 'International' markers. Doing it this way means I
    // don't have to modify anything but the class target to add this feature.
    //mapState.markerCluster = new MarkerClusterer(mapState.map, [],mcOptions)         
    let countActiveMarkers = document.querySelectorAll('.c-locations__item:not(.c-locations__item--disabled) meta[name*="location"]').length

    $('.c-locations__item:not(.c-locations__item--disabled) meta[name*="location"]').each((el) => {
        let data = _prepData(el.getAttribute('value'))


        window.setTimeout(() => {
            let marker = new google.maps.Marker({
                position: {
                    lat: data.lat,
                    lng: data.lng
                },
                map: mapState.map,
                title: data.title,
                animation: google.maps.Animation.DROP,
                icon: '/assets/img/pin.png'
            })

            countMarkers = countMarkers +1

            // DEV: Save the rendered content for later usage in the infoBox
            marker.content = data.content
            marker.title = data.title
            marker.link = data.link

            marker.addListener('click', function() {
                infowindow.close();
                toggleMarker(marker)
            })

            mapState.markers.push(marker)
            mapState.markerCluster.addMarker(marker, false)

        
                
            if( isSubmit ){
                
                infowindow.close();

                var newBoundary = new google.maps.LatLngBounds();

                for(index in mapState.markers){
                  var position = mapState.markers[index].position;
                  newBoundary.extend(position);
                }

                mapState.map.fitBounds(newBoundary);
            
            }
                


            google.maps.event.addListener(mapState.markerCluster, 'mouseover', function(cluster) {

                marker.setIcon('/assets/img/pin.svg')

                var markers = cluster.getMarkers();
                let content = "";
                let oneMarker = "";

                markers.forEach(function(element) {
                                
                    let  additionalTitleJ="";
                    let contentToAdd = "";
                    let tempMarker = element;
                    content += "<span class='c-pane__link'><a target='_blank' href='"+ element.link +"'>";
                    content += element.title;
                    content += "</a></span><br>";

                });

                markers.slice(1).forEach(function(element) {
                    oneMarker = markers[0]
                });

                let infoWindow = new google.maps.InfoWindow();
                let info = new google.maps.MVCObject;
                
                info.set('position', cluster.center_);
                mapState.infoBox.setVisible(false)

                infowindow.close();
                infowindow.setContent(content);
                infowindow.open(mapState.map, info);

            });  
            google.maps.event.addListener(mapState.markerCluster, 'mouseout', function(cluster) {
                //infowindow.close();
            });  

            google.maps.event.addListener(mapState.markerCluster, 'clusterclick', function(cluster) {
                infowindow.close();
            });  
                        
        }, index * 25)

        index++
    })

    mapState.markerCluster.resetViewport_()
    mapState.markerCluster.repaint()

    $(':map').removeClass('c-map--loading')

    // DEV: If the user previously revealed all locations in the list, remove
    // the hidden 'Show More' button to prep for the new list.
    $(':revealLocations').removeClass('c-locations__item--disabled')

    if (callback) {
        callback()
    }
}

function bindFinderForm() {
    $(':fetchLocations').on('submit', (e, el) => {
        let distance = $('[data-type="distanceParam"]').first(),
            address = $('[data-ref="address"]').first();

        if (distance.value && address.value) {
           fetchLocations(el)
        }
 
        e.preventDefault()
    })

    $(':resultsResetBtn').on('click', (e, el) => {
        updateLocationData()
    })

}

function fetchLocations(el) {
    $(':map').addClass('c-map--loading')
    if (mapState.infoBox) {
        mapState.infoBox.close()
    }

    axios.post('/', serialize(el)).then(function(response) {
        $(':ajaxReplace')[0].innerHTML = response.data

        // DEV: Re-bind the 'Show More' element
        $(':revealLocations').on('click', revealLocations)
        updateLocationData(true)

    
        // TODO: The markers aren't ready to be counted yet; there's a timeout
        // in loadMarkers. Somehow find a way to do this after you know all
        // markers have been added to the array.
        let count = $(':ajaxReplace').find('.c-locations__item').length;

        $(':ajaxifiedTitle')[0].innerText = count + " Locations Near '" + $(':address')[0].value + "'"
        $(':showLabel').hide()
        $(':resultsResetBtn').show()

    })
}

function toggleMarker(marker) {
    let previousMarker = mapState.currentMarker

    if (previousMarker) {
        previousMarker.setIcon('/assets/img/pin.svg')
    }

    marker.setIcon('/assets/img/pin-selected.svg')

    mapState.currentMarker = marker

    mapState.infoBox.setContent(marker.content)

    mapState.infoBox.setVisible(true)

    mapState.infoBox.open(mapState.map, marker)

    // DEV: Modify this to fix the position of the viewport on mobile.
    mapState.map.panTo(marker.getPosition())

    // TODO: There's a race condition somewhere. See if this can be attached as
    // a callback to the 'open' event of the infoBox. (On line 452 of this method.)
    // The 'domready' event on the infoBox would be perfect.
    // http://htmlpreview.github.io/?https://github.com/googlemaps/v3-utility-library/blob/master/infobox/docs/reference.html
    setTimeout(function() {
        google.maps.event.addDomListener(document.querySelector('.c-pane__close'), 'click', function() {
            mapState.infoBox.setVisible(false)

            mapState.currentMarker.setIcon('/assets/img/pin.svg')

            mapState.currentMarker = null
        })
    }, 250)
}

function _prepData(value) {
    let data = JSON.parse(value)

    data.lat = parseFloat(data.lat)
    data.lng = parseFloat(data.lng)
    data.content = _renderTemplate(data)

    return data
}

function _ajax(type, url, data = false, handler) {
    let request = new XMLHttpRequest()

    request.onreadystatechange = function() {
        if (request.readyState == XMLHttpRequest.DONE) {
            if (request.status == 200) {
                handler(request.responseText, 200)
            } else if (request.status == 400) {
                handler(request.responseText, 400)
            } else {
                handler(request.responseText, false)
            }
        }
    }

    request.open(type, url, true)
    request.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded; charset=UTF-8;')
    request.setRequestHeader('X-Requested-With', 'XMLHttpRequest')
    request.send(data)
}

function _renderTemplate(data) {
    let {
        title,
        distance,
        address,
        phone,
        link
    } = data

    return `
        <span class="c-pane__title">${title} <span class="t-light-gray c-pane__distance">| ${distance}</span></span>
        <span class="t-light-gray c-pane__address">${address}</span>
        <span class="t-light-gray c-pane__number">${phone}</span>
        <a href="${link}" class="c-pane__link">More Info</a>
        <span class="c-pane__close"></span>
    `
}

function moveLocationBlocks() {
    let locationFinder = $(':locationFinder').els[0],
        locationList = $(':locationList').els[0],
        parentNode = locationFinder.parentNode

    if (window.innerWidth > 767) {
        parentNode.insertBefore(locationFinder, locationList)
    } else {
        parentNode.insertBefore(locationList, locationFinder)
    }
}

export default Object.assign(init, {})
