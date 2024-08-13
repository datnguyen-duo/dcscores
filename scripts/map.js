document.addEventListener("DOMContentLoaded", function () {
  var mapData = mapSettings.map;

  var pin = mapData.pin
      ? mapData.pin.url
      : mapSettings.themeurl + "/assets/pin.png",
    pin_highlighted = mapData.pin_highlighted
      ? mapData.pin_highlighted.url
      : mapSettings.themeurl + "/assets/pin-highlighted.png",
    pin_center = mapData.pin_center
      ? mapData.pin_center.url
      : mapSettings.themeurl + "/assets/pin-center-2.png",
    zoom_level = mapData.zoom_level ? mapData.zoom_level : 14,
    geo_json = mapSettings.themeurl + "/assets/dc-wards.geojson";
  mapboxgl.accessToken = mapSettings.access_token;

  var map = new mapboxgl.Map({
    container: "map",
    style: mapData.style,
    center: [mapData.center_point.longitude, mapData.center_point.latitude],
    zoom: zoom_level,
  });
  if (mapData["show_controls"]) {
    map.addControl(new mapboxgl.NavigationControl());
  }
  map.scrollZoom.disable();
  var locations = [
    {
      name: "center-point",
      lat: mapData.center_point.latitude,
      lon: mapData.center_point.longitude,
      year: mapData.center_point.year,
      address: mapData.center_point.address,
    },
    ...mapData.points.map((point) => {
      return {
        name: point.name,
        lat: point.latitude,
        lon: point.longitude,
        year: point.year,
        address: point.address,
      };
    }),
  ];
  const renderMapItems = (_locations) =>
    (document.getElementById("map-items").innerHTML = _locations
      .map(
        (el, id) =>
          `<div class="map-button-container"><button class='clean-button map-item-button headline-3' onclick="highlightItem('${el.name.replace(
            "'",
            "\\'"
          )}', ${id + 1})"><div class="circle-list-item">${id + 1}</div> ${
            el.name
          }</button></div>`
      )
      .join(" ")
      .toString());

  const _locations = locations.filter((location) => {
    return location.name !== "center-point";
  });

  const popup = new mapboxgl.Popup({
    closeButton: true,
    closeOnClick: false,
    offset: 40,
  });

  popup.on("close", () => {
    map.getSource("location-highlighted").setData({
      type: "FeatureCollection",
      features: [],
    });
  });

  map.on("load", function () {
    map.addSource("dc-wards", {
      type: "geojson",
      data: geo_json,
    });

    map.addLayer({
      id: "dc-wards-fill",
      type: "fill",
      source: "dc-wards",
      paint: {
        "fill-color": [
          "match",
          ["get", "WARD"],
          1,
          "#fac831",
          2,
          "#d92314",
          3,
          "#0868f8",
          4,
          "#d92314",
          5,
          "#0868f8",
          6,
          "#fac831",
          7,
          "#d92314",
          8,
          "#0868f8",
          "#0868f8",
        ],
        "fill-opacity": 0.2,
      },
    });
    map.addLayer({
      id: "dc-wards-line",
      type: "line",
      source: "dc-wards",
      paint: {
        "line-color": [
          "match",
          ["get", "WARD"],
          1,
          "#fac831",
          2,
          "#d92314",
          3,
          "#0868f8",
          4,
          "#d92314",
          5,
          "#0868f8",
          6,
          "#fac831",
          7,
          "#d92314",
          8,
          "#0868f8",
          "#0868f8",
        ],
        "line-width": 1,
      },
    });

    map.loadImage(pin, (error, image) => {
      if (error) {
        console.log(error);
        throw error;
      }
      map.addImage("pin", image);

      map.addSource("locations", {
        type: "geojson",
        data: {
          type: "FeatureCollection",
          features: createFeatures(_locations),
        },
      });
      map.addSource("locations-number", {
        type: "geojson",
        data: {
          type: "FeatureCollection",
          features: createFeatures(_locations),
        },
      });

      // renderMapItems(_locations);
      const locationsLoaded = map.getLayer("location-highlighted")
        ? true
        : false;

      map.addLayer(
        {
          id: "locations",
          source: "locations",
          type: "symbol",
          layout: {
            "icon-image": "pin",
            "icon-size": 0.8,
            // "text-field": ["get", "label"],
            // "text-font": ["Arial Unicode MS Bold"],
            // "text-offset": [0, -0.25],
            // "text-size": 12,
            // "text-allow-overlap": true,
            // "text-ignore-placement": true,
            "icon-allow-overlap": true,
            "icon-ignore-placement": true,
          },
          paint: {
            "text-color": "#ffffff",
          },
        },
        locationsLoaded ? "location-highlighted" : undefined
      );

      map.on("mouseenter", "locations", () => {
        map.getCanvas().style.cursor = "pointer";
      });

      map.on("mouseleave", "locations", () => {
        map.getCanvas().style.cursor = "";
      });

      map.on("click", "locations", (e) => {
        if (!e.features[0]) return;
        highlightItem(
          e.features[0].properties.name,
          e.features[0].properties.label
        );
      });
    });

    map.loadImage(pin_highlighted, (error, image) => {
      if (error) return;
      map.addImage("pin-highlighted", image);

      map.addSource("location-highlighted", {
        type: "geojson",
        data: {
          type: "FeatureCollection",
          features: [],
        },
      });
      map.addSource("location-highlighted-number", {
        type: "geojson",
        data: {
          type: "FeatureCollection",
          features: [],
        },
      });

      map.addLayer({
        id: "location-highlighted",
        source: "location-highlighted",
        type: "symbol",

        layout: {
          "icon-image": "pin-highlighted",
          "icon-size": 1.2,
          // "text-field": ["get", "label"],
          // "text-font": ["Arial Unicode MS Bold"],
          // "text-offset": [0, -0.25],
          // "text-size": 12,
          // "text-allow-overlap": true,
          // "text-ignore-placement": true,
          "icon-allow-overlap": true,
          "icon-ignore-placement": true,
        },
        paint: {
          "text-color": "#ffffff",
        },
      });
    });

    map.loadImage(pin_center, (error, image) => {
      if (error) return;
      map.addImage("pin-center", image);

      const centerPoint = [
        locations.find((location) => {
          return location.name === "center-point";
        }),
      ];

      map.addSource("centerPoint", {
        type: "geojson",
        data: {
          type: "FeatureCollection",
          features: createFeatures(centerPoint),
        },
      });

      map.addLayer({
        id: "centerPoint",
        source: "centerPoint",
        type: "symbol",
        layout: {
          "icon-image": "pin-center",
          "icon-size": 0.9,
          "icon-allow-overlap": false,
        },
      });
    });
  });

  const createFeatures = (locations, label) => {
    return locations.map((location, id) => {
      return {
        type: "Feature",
        geometry: {
          type: "Point",
          coordinates: [location.lon, location.lat],
        },
        properties: {
          label: label ? label.toString() : `${id + 1}`,
          name: location.name,
          category: location.category,
        },
      };
    });
  };

  const highlightItem = (id, label) => {
    const highlighted = map.getSource("location-highlighted");
    const text = map.getSource("location-highlighted-number");

    if (!highlighted || !text) return;
    else {
      const location = locations.find((loc) => loc.name === id);
      if (!location) return;
      else {
        map.getSource("location-highlighted").setData({
          type: "FeatureCollection",
          features: createFeatures([location], label),
        });
        map.getSource("location-highlighted-number").setData({
          type: "FeatureCollection",
          features: createFeatures([location], label),
        });

        popup
          .setLngLat([location.lon, location.lat])
          .setHTML(
            `<h6>${location.name}</h6><p>Active Since: ${location.year}</p><p>${location.address}</p>`
          )

          .addTo(map);

        // map.fitBounds(
        //   new mapboxgl.LngLatBounds(
        //     [location.lon, location.lat],
        //     [location.lon, location.lat]
        //   ),
        //   {
        //     maxZoom: zoom_level,
        //   }
        // );
      }
    }
  };
});
