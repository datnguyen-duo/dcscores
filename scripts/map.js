document.addEventListener("DOMContentLoaded", function () {
  var mapData = mapSettings.map;

  var pin = mapData.pin
      ? mapData.pin
      : mapSettings.themeurl + "/assets/pin.png",
    pin_highlighted = mapData.pin_highlighted
      ? mapData.pin_highlighted
      : mapSettings.themeurl + "/assets/pin-highlighted.png",
    pin_center = mapData.pin_center
      ? mapData.pin_center
      : mapSettings.themeurl + "/assets/pin-center-2.png",
    zoom_level = mapData.zoom_level ? mapData.zoom_level : 14,
    geo_json = mapSettings.themeurl + "/assets/dc-wards.geojson";
  mapboxgl.accessToken = mapSettings.access_token;

  var map = new mapboxgl.Map({
    container: "map",
    // style: mapData.style,
    style: "mapbox://styles/duostudio/cllr572sa00nu01ma2yd573an",
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
    },
    ...mapData.points.map((point) => {
      return {
        name: point.name,
        lat: point.latitude,
        lon: point.longitude,
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

  map.on("load", function () {
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
            "icon-size": 0.3,
            "text-field": ["get", "label"],
            "text-font": ["Arial Unicode MS Bold"],
            "text-offset": [0, -0.25],
            "text-size": 12,
            "text-allow-overlap": true,
            "text-ignore-placement": true,
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
          "icon-size": 0.4,
          "text-field": ["get", "label"],
          "text-font": ["Arial Unicode MS Bold"],
          "text-offset": [0, -0.25],
          "text-size": 12,
          "text-allow-overlap": true,
          "text-ignore-placement": true,
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
          "icon-size": 0.4,
          "icon-allow-overlap": false,
        },
      });
    });

    map.addSource("dc-wards", {
      type: "geojson",
      data: geo_json, // replace with the path to your GeoJSON file
    });

    // Add a layer for the boundary
    map.addLayer({
      id: "dc-wards-fill",
      type: "fill",
      source: "dc-wards",
      paint: {
        "fill-color": [
          "match",
          ["get", "WARD"],
          1,
          "#f00",
          2,
          "#0f0",
          3,
          "#00f",
          4,
          "#ff0",
          5,
          "#f0f",
          6,
          "#0ff",
          7,
          "#f00",
          8,
          "#0f0",
          "#ccc", // default color if 'WARD' doesn't match any of the above
        ],
        "fill-opacity": 0.4,
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
          "#f00",
          2,
          "#0f0",
          3,
          "#00f",
          4,
          "#ff0",
          5,
          "#f0f",
          6,
          "#0ff",
          7,
          "#f00",
          8,
          "#0f0",
          "#ccc", // default color if 'WARD' doesn't match any of the above
        ],
        "line-width": 1,
      },
    });

    map.on("click", "dc-wards", function (e) {
      console.log(e);
    });
  });

  const filterLocations = (type) => {
    unhighlightItem();
    const _locations = locations.filter((location) => {
      return location.category === type;
    });
    map.getSource("locations").setData({
      type: "FeatureCollection",
      features: createFeatures(_locations),
    });
    map.getSource("locations-number").setData({
      type: "FeatureCollection",
      features: createFeatures(_locations),
    });
    document.querySelectorAll(".map-button").forEach((button) => {
      button.classList.remove("map-button-active");
    });
    document
      .getElementById(`${type.toLowerCase()}-map-button`)
      .classList.add("map-button-active");

    // renderMapItems(_locations);

    adjustMapBoundsToFeatures(map, "locations");

    // document.querySelectorAll(".map-button-container").forEach((item) => {
    //   item.classList.remove("active");
    // });
  };

  function adjustMapBoundsToFeatures(map, sourceId) {
    // Get the source data (GeoJSON) from the map's data source
    const sourceData = map.getSource(sourceId)._data;

    if (!sourceData || !sourceData.features.length) {
      console.log("No features to adjust bounds to.");
      return;
    }

    // Initialize the bounds with the coordinates of the first feature
    let bounds = new mapboxgl.LngLatBounds();

    // Loop through all features to expand the bounds
    sourceData.features.forEach((feature) => {
      const coords = feature.geometry.coordinates;

      // Extend the bounds with the coordinates of the current feature
      bounds.extend(coords);
    });

    // Set the map's bounds to fit all features
    map.fitBounds(bounds, {
      duration: 1000,
      padding: 100, // Optional padding around the bounds
    });
  }

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
        const popup = document.getElementById("map-popup");
        const title = document.getElementById("map-popup-title");
        const address = document.getElementById("map-popup-address");
        const url = document.getElementById("map-popup-url");

        popup.style.display = "block";
        title.textContent = location.name;
        address.textContent = location.address;
        url.href = `https://www.google.com/maps?q=${location.lat},${location.lon}`;

        // Adjust map bounds to the highlighted location
        map.fitBounds(
          new mapboxgl.LngLatBounds(
            [location.lon, location.lat],
            [location.lon, location.lat]
          ),
          {
            maxZoom: zoom_level,
          }
        );
      }
    }

    // document.querySelectorAll(".map-button-container").forEach((item) => {
    //   item.classList.remove("active");
    // });
    // document
    //   .querySelectorAll(".map-button-container")
    //   [label - 1].classList.add("active");
  };

  const unhighlightItem = () => {
    document.getElementById("map-popup").style.display = "none";
    map.getSource("location-highlighted").setData({
      type: "FeatureCollection",
      features: [],
    });
    map.getSource("location-highlighted-number").setData({
      type: "FeatureCollection",
      features: [],
    });
  };
});
