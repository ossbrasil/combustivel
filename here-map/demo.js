
var testeroteirizacao = {
  "rotas": [

    {
      "id": 0,
      "Cep": "09230-580",
      "Rua": "Rua Santa Isabel",
      "Bairro": "Vila Camilu00f3polis",
      "CidadeEstado": "Santo Andru00e9 - SP",
      "numeroCep": "583",
      "Complemento": "Nu00e3o Consta",
      "geocode": {
        "Latitude": -23.62403,
        "Longitude": -46.52557
      }
    }
    ,

    {
      "id": 1,
      "Cep": "09230-580",
      "Rua": "Rua Santa Isabel",
      "Bairro": "Vila Camilu00f3polis",
      "CidadeEstado": "Santo Andru00e9 - SP",
      "numeroCep": "583",
      "Complemento": "Nu00e3o Consta",
      "geocode": {
        "Latitude": -23.12345,
        "Longitude": -46.12345
      }
    }

  ]
}


/**
 * Calculates and displays a car route from the Brandenburg Gate in the centre of Berlin
 * to Friedrichstraße Railway Station.
 *
 * A full list of available request parameters can be found in the Routing API documentation.
 * see:  http://developer.here.com/rest-apis/documentation/routing/topics/resource-calculate-route.html
 *
 * @param   {H.service.Platform} platform    A stub class to access HERE services
 */

// function calculateRouteFromAtoB(platform) {
//   var router = platform.getRoutingService(),
//     routeRequestParams = {
//       mode: 'fastest;car',
//       language: 'pt-BR',
//       representation: 'display',
//       routeattributes: 'waypoints,summary,shape,legs',
//       maneuverattributes: 'direction,action',
//       waypoint0: '-23.5548563,-46.6059481', // Brandenburg Gate
//       waypoint1: '-23.6582225,-46.6837123',  // Friedrichstraße Railway Station
//       waypoint2: '-23.5158133,-46.605849',  // Friedrichstraße Railway Station
//       waypoint3: '-23.4789466,-46.6377569', // Friedrichstraße Railway Station
//       waypoint4: '-23.5548563,-46.672425',  // Friedrichstraße Railway Station
//       waypoint5: '-23.6229058,-46.526797',  // Friedrichstraße Railway Station
//       waypoint6: '-22.2327616,-48.7251636',  // Friedrichstraße Railway Station
//       waypoint7: '-12.2649006,-38.9455224',  // Friedrichstraße Railway Station
//       waypoint8: '-9.9671749,-67.8492359',  // Friedrichstraße Railway Station
//       waypoint9: '0.9692299,-50.8003794',  // Friedrichstraße Railway Station
//       waypoint10: '-32.1967889,-52.1765581',  // Friedrichstraße Railway Station

//     };

//   router.calculateRoute(
//     routeRequestParams,
//     onSuccess,
//     onError
//   );
// }

function addMarkersToMap(map, testeroteirizacao, platform) {

  map.removeObjects(map.getObjects())

  console.log(JSON.stringify(testeroteirizacao))

  jResponse = testeroteirizacao

  var router = platform.getRoutingService(),
  routeRequestParams = {
    mode: 'fastest;car',
    language: 'pt-BR',
    representation: 'display',
    routeattributes: 'waypoints,summary,shape,legs',
    maneuverattributes: 'direction,action',
  };

  var count = 0

  jResponse.rotas.map((item) => {
    let coordLat = item.geocode.Latitude
    let coordLgt = item.geocode.Longitude
    count++

    eval('waypoint_' + count + '= new H.map.Marker({ lat: ' + coordLat + ', lng: ' + coordLgt + ' })');
    map.addObject(window["waypoint_" + count]);

    var i = count - 1
    var coords = coordLat + ',' + coordLgt

    routeRequestParams["waypoint"+i] = coords
  })

  console.log(routeRequestParams)

  router.calculateRoute(
    routeRequestParams,
    onSuccess,
    onError
  );
}

// function AtualizaCords(platform) {
//   //Limpa as info anteriores
//   map.removeObjects(map.getObjects())


//   //Adiciona os Waypoint's
//   var waypoint_1 = new H.map.Marker({ lat: -23.6251542, lng: -46.524343 });
//   map.addObject(waypoint_1);

//   var waypoint_2 = new H.map.Marker({ lat: -23.6446382, lng: -46.5123512 });
//   map.addObject(waypoint_2);

//   var waypoint_3 = new H.map.Marker({ lat: -23.6915671, lng: -46.5615264 });
//   map.addObject(waypoint_3);

//   //Adiciona o Trajeto
//   var router = platform.getRoutingService(),
//     routeRequestParams = {
//       mode: 'fastest;car',
//       language: 'pt-BR',
//       representation: 'display',
//       routeattributes: 'waypoints,summary,shape,legs',
//       maneuverattributes: 'direction,action',
//       waypoint0: '-23.6251542,-46.524343',
//       waypoint1: '-23.6446382,-46.5123512',
//       waypoint2: '-23.6915671,-46.5615264',
//     };


//   router.calculateRoute(
//     routeRequestParams,
//     onSuccess,
//     onError
//   );
// }



// function closeMap() {
//   // map.removeObject(setMarker);
// }


/**
 * This function will be called once the Routing REST API provides a response
 * @param  {Object} result          A JSONP object representing the calculated route
 *
 * see: http://developer.here.com/rest-apis/documentation/routing/topics/resource-type-calculate-route.html
 */
function onSuccess(result) {
  var route = result.response.route[0];

  //Mapa
  //Desenho da Rota
  addRouteShapeToMap(route);

  //Painel
  addWaypointsToPanel(route.waypoint);
  addManueversToPanel(route);
  addSummaryToPanel(route.summary);
}

/**
 * This function will be called if a communication error occurs during the JSON-P request
 * @param  {Object} error  The error message received.
 */
function onError(error) {
  alert('Can\'t reach the remote server');
}

/**
 * Boilerplate map initialization code starts below:
 */

// set up containers for the map  + panel
var mapContainer = document.getElementById('map'),
  routeInstructionsContainer = document.getElementById('panel');

//Step 1: initialize communication with the platform
// In your own code, replace variable window.apikey with your own apikey
var platform = new H.service.Platform({
  ml: 'por',
  apikey: "EQUa36DhAVzcX_tvfQkMBhmg-3bI3Q8ii2JGCpj1hms"
});

var defaultLayers = platform.createDefaultLayers();

//Step 2: initialize a map - this map is centered over Berlin
var map = new H.Map(mapContainer,
  defaultLayers.vector.normal.map, {
  center: { lat: -23.5158105, lng: -46.6059481 },
  zoom: 10,
  pixelRatio: window.devicePixelRatio || 1
});
// add a resize listener to make sure that the map occupies the whole container
window.addEventListener('resize', () => map.getViewPort().resize());

//Step 3: make the map interactive
// MapEvents enables the event system
// Behavior implements default interactions for pan/zoom (also on mobile touch environments)
var behavior = new H.mapevents.Behavior(new H.mapevents.MapEvents(map));

// Create the default UI components
var ui = H.ui.UI.createDefault(map, defaultLayers, 'pt-BR');

// Hold a reference to any infobubble opened
var bubble;

/**
 * Opens/Closes a infobubble
 * @param  {H.geo.Point} position     The location on the map.
 * @param  {String} text              The contents of the infobubble.
 */
function openBubble(position, text) {
  if (!bubble) {
    bubble = new H.ui.InfoBubble(
      position,
      // The FO property holds the province name.
      { content: text });
    ui.addBubble(bubble);
  } else {
    bubble.setPosition(position);
    bubble.setContent(text);
    bubble.open();
  }
}


/**
 * Creates a H.map.Polyline from the shape of the route and adds it to the map.
 * @param {Object} route A route as received from the H.service.RoutingService
 */
function addRouteShapeToMap(route) {
  var lineString = new H.geo.LineString(),
    routeShape = route.shape,
    polyline;

  routeShape.forEach(function (point) {
    var parts = point.split(',');
    lineString.pushLatLngAlt(parts[0], parts[1]);
  });

  polyline = new H.map.Polyline(lineString, {
    style: {
      lineWidth: 4,
      strokeColor: 'rgba(0, 128, 255, 0.7)'
    }
  });
  // Add the polyline to the map
  map.addObject(polyline);
  // And zoom to its bounding rectangle
  map.getViewModel().setLookAtData({
    bounds: polyline.getBoundingBox()
  });
}


/**
 * Creates a series of H.map.Marker points from the route and adds them to the map.
 * @param {Object} route  A route as received from the H.service.RoutingService
 */
function addManueversToMap(route) {
  var svgMarkup = '<svg width="18" height="18" ' +
    'xmlns="http://www.w3.org/2000/svg">' +
    '<circle cx="8" cy="8" r="8" ' +
    'fill="#1b468d" stroke="white" stroke-width="1"  />' +
    '</svg>',
    dotIcon = new H.map.Icon(svgMarkup, { anchor: { x: 8, y: 8 } }),
    group = new H.map.Group(),
    i,
    j;

  // Add a marker for each maneuver
  for (i = 0; i < route.leg.length; i += 1) {
    for (j = 0; j < route.leg[i].maneuver.length; j += 1) {
      // Get the next maneuver.
      maneuver = route.leg[i].maneuver[j];
      // Add a marker to the maneuvers group
      var marker = new H.map.Marker({
        lat: maneuver.position.latitude,
        lng: maneuver.position.longitude
      },
        { icon: dotIcon });
      marker.instruction = maneuver.instruction;
      group.addObject(marker);
    }
  }

  group.addEventListener('tap', function (evt) {
    map.setCenter(evt.target.getGeometry());
    openBubble(
      evt.target.getGeometry(), evt.target.instruction);
  }, false);

  // Add the maneuvers group to the map
  map.addObject(group);
}


/**
 * Creates a series of H.map.Marker points from the route and adds them to the map.
 * @param {Object} route  A route as received from the H.service.RoutingService
 */
function addWaypointsToPanel(waypoints) {



  var nodeH3 = document.createElement('h3'),
    waypointLabels = [],
    i;


  for (i = 0; i < waypoints.length; i += 1) {
    waypointLabels.push(waypoints[i].label)
  }

  nodeH3.textContent = waypointLabels.join(' - ');

  routeInstructionsContainer.innerHTML = '';
  routeInstructionsContainer.appendChild(nodeH3);
}

/**
 * Creates a series of H.map.Marker points from the route and adds them to the map.
 * @param {Object} route  A route as received from the H.service.RoutingService
 */
function addSummaryToPanel(summary) {
  var summaryDiv = document.createElement('div'),
    content = '';
  if (summary.distance < 1000) {
    content += '<b>Distancia da Viagem</b>: ' + summary.distance + ' m. <br/>';
  } else {
    content += '<b>Distancia da Viagem</b>: ' + (summary.distance / 1000).toFixed(1) + ' KM. <br/>';
  }
  content += '<b>Tempo de Viagem</b>: ' + summary.travelTime.toMMSS() + ' (No Transito atual)';


  summaryDiv.style.fontSize = 'small';
  summaryDiv.style.marginLeft = '5%';
  summaryDiv.style.marginRight = '5%';
  summaryDiv.innerHTML = content;
  routeInstructionsContainer.appendChild(summaryDiv);
}

/**
 * Creates a series of H.map.Marker points from the route and adds them to the map.
 * @param {Object} route  A route as received from the H.service.RoutingService
 */
function addManueversToPanel(route) {
  var nodeOL = document.createElement('ol'),
    i,
    j;

  nodeOL.style.fontSize = 'small';
  nodeOL.style.marginLeft = '5%';
  nodeOL.style.marginRight = '5%';
  nodeOL.className = 'directions';

  // Add a marker for each maneuver
  for (i = 0; i < route.leg.length; i += 1) {
    for (j = 0; j < route.leg[i].maneuver.length; j += 1) {
      // Get the next maneuver.
      maneuver = route.leg[i].maneuver[j];

      var li = document.createElement('li'),
        spanArrow = document.createElement('span'),
        spanInstruction = document.createElement('span');

      spanArrow.className = 'arrow ' + maneuver.action;
      spanInstruction.innerHTML = maneuver.instruction;
      li.appendChild(spanArrow);
      li.appendChild(spanInstruction);

      nodeOL.appendChild(li);
    }
  }

  routeInstructionsContainer.appendChild(nodeOL);
}


Number.prototype.toMMSS = function () {
  return Math.floor(Math.floor(this / 60) / 60) + ':' + (Math.floor(Math.floor(this / 60) % 60));
}

// Now use the map as required...
// calculateRouteFromAtoB(platform);

// Now use the map as required...
// window.onload = function () {
//   addMarkersToMap(map);
// }                
