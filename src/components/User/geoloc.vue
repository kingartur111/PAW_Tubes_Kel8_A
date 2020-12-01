<template>
    <v-footer>
    <div id="mapContainer" class="basemap"></div>
    </v-footer>
</template>

<script>
import mapboxgl from "mapbox-gl";

export default {
  data() {
    return {
      accessToken: "pk.eyJ1IjoiZW5mb2xkIiwiYSI6ImNrZmx5bXQ1YTFmZjcycnBrcXdrZmNrZjkifQ.9LGKOdQeW4ZvuAoUPZe5zg",
    };
  },
  mounted() {
    mapboxgl.accessToken = this.accessToken;

    new mapboxgl.Map({
      container: "mapContainer",
      style: "mapbox://styles/mapbox/streets-v11",
      center: [103.811279, 1.345399],
      zoom: 12,
      maxBounds: [
        [103.6, 1.1704753],
        [104.1, 1.4754753],
      ],
    });
  },
};
</script>
