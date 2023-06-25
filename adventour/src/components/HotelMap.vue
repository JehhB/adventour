<template>
  <div
    class="flex w-full flex-col overflow-hidden rounded-3xl px-2 sm:px-0 md:h-[400px] md:flex-row-reverse"
  >
    <div class="aspect-h-12 aspect-w-16 z-0 md:aspect-none md:flex-1">
      <div class="md:h-full">
        <LMap
          ref="map"
          :zoom="15"
          :max-zoom="15"
          :center="[lat, lng]"
          :options="{
            zoomControl: false,
            attributionControl: false,
          }"
          @update:bounds="onMove"
          @ready="onMove"
        >
          <LMarker :lat-lng="[lat, lng]" :icon="currentMarker">
            <LPopup>
              <slot></slot>
            </LPopup>
          </LMarker>

          <LLayerGroup>
            <LMarker
              v-for="hotel in data"
              :lat-lng="[hotel.lat, hotel.lng]"
              :icon="hotelMarker"
              :key="hotel.hotel_id"
            >
              <LPopup>
                <Summary
                  :link="hotel.link"
                  :image="hotel.image"
                  :caption="hotel.alt"
                  :title="hotel.name"
                  :subtitle="hotel.address"
                />
              </LPopup>
            </LMarker>
          </LLayerGroup>

          <LTileLayer url="/storage/tiles/{z}/{x}/{y}.webp" />
          <LControlZoom position="bottomright"></LControlZoom>
        </LMap>
      </div>
    </div>
    <div
      class="flex h-[300px] flex-col gap-3 bg-gray-200 py-4 md:h-full md:w-[25rem]"
    >
      <h3 class="px-4 text-base font-semibold leading-none text-gray-800">
        Recommendation in the area
      </h3>
      <template v-if="statusCode === null || data?.length !== 0">
        <ul class="flex-1 list-none space-y-2 overflow-y-auto px-4">
          <template v-if="statusCode === null">
            <li v-for="i in 3" :key="i">
              <div class="flex gap-2">
                <div
                  class="block-loader h-[76px] w-[76px] shrink-0 rounded"
                ></div>
                <div class="flex flex-1 flex-col gap-2">
                  <div class="block-loader mt-2 h-6 w-4/5 rounded"></div>
                  <div class="block-loader h-4 w-2/3 rounded"></div>
                </div>
              </div>
            </li>
          </template>

          <template v-else>
            <li v-for="hotel in data" :key="hotel.hotel_id">
              <Summary
                :link="hotel.link"
                :image="hotel.image"
                :caption="hotel.alt"
                :title="hotel.name"
                :subtitle="hotel.address.replace(/,\s*\d{4}.*?$/, '')"
              />
            </li>
          </template>
        </ul>
      </template>
      <template v-else>
        <em class="px-4 text-gray-800">No recommendation in the area</em>
      </template>
    </div>
  </div>
</template>
<script setup lang="ts">
import "leaflet/dist/leaflet.css";
import {
  LControlZoom,
  LLayerGroup,
  LMap,
  LMarker,
  LPopup,
  LTileLayer,
} from "@vue-leaflet/vue-leaflet";
import * as L from "leaflet/dist/leaflet-src.esm";
import Summary from "./Summary.vue";
import { defineProps, ref } from "vue";
import { useFetch } from "@vueuse/core";

const props = defineProps<{
  lat: number;
  lng: number;
  hotelId: number;
}>();

const map = ref<InstanceType<typeof LMap>>();
window.L = L;

const currentMarker = L.icon({
  iconUrl: require("../assets/images/marker-icon.png"),
  iconRetinaUrl: require("../assets/images/marker-icon-2x.png"),
  iconSize: [30, 40],
  iconAnchor: [15, 40],
  popupAnchor: [0, -32],
});

const hotelMarker = L.icon({
  iconUrl: require("../assets/images/building-icon.png"),
  iconRetinaUrl: require("../assets/images/building-icon-2x.png"),
  iconSize: [24, 32],
  iconAnchor: [12, 32],
  popupAnchor: [0, -28],
});

const url = ref("");
const { data, statusCode } = useFetch(url, {
  refetch: true,
  immediate: false,
})
  .get()
  .json<
    {
      hotel_id: number;
      lat: number;
      lng: number;
      link: string;
      image: string;
      alt: string;
      name: string;
      address: string;
    }[]
  >();

function onMove() {
  if (map.value === undefined) return;
  const bounds = map.value.leafletObject?.getBounds();
  if (bounds === undefined) return;
  const lat0 = bounds.getNorth();
  const lat1 = bounds.getSouth();
  const lng0 = bounds.getEast();
  const lng1 = bounds.getWest();

  url.value = `/api/hotel-area.php?lat0=${lat0}&lng0=${lng0}&lat1=${lat1}&lng1=${lng1}&exclude=${props.hotelId}`;
}
</script>
<style scoped>
>>> .leaflet-control-zoom {
  border: 1px solid var(--gray-400) !important;
  margin: 0 1rem 1rem 0 !important;
  border-radius: 8px;
}

>>> .leaflet-control-zoom a:first-child {
  border-radius: 8px 8px 0 0 !important;
}

>>> .leaflet-control-zoom a:last-child {
  border-radius: 0 0 8px 8px !important;
  border-bottom: none;
}

>>> .leaflet-control-zoom a {
  color: var(--accent-color);
  border-bottom: 1px solid var(--gray-400);
  font-weight: 400;
}
</style>
