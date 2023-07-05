<template>
  <div
    class="flex w-full flex-col overflow-hidden rounded-3xl px-2 sm:px-0 md:h-[400px] md:flex-row-reverse"
  >
    <div class="aspect-h-12 aspect-w-16 relative z-0 md:aspect-none md:flex-1">
      <div class="md:h-full">
        <LMap
          ref="map"
          :zoom="zoom"
          :max-zoom="15"
          :center="[lat, lng]"
          :options="{
            zoomControl: false,
            attributionControl: false,
          }"
          @update:bounds="onMove"
          @ready="onMove"
        >
          <LMarker
            v-if="!noCurrent"
            :lat-lng="[lat, lng]"
            :icon="currentMarker"
          >
            <LPopup>
              <slot></slot>
            </LPopup>
          </LMarker>

          <LLayerGroup>
            <LMarker
              v-for="location in data"
              :lat-lng="[location.lat, location.lng]"
              :icon="location.type === 'hotel' ? hotelMarker : pinMarker"
              :key="location.id"
            >
              <LPopup>
                <Summary
                  :icon="icons[location.type]"
                  :link="location.link"
                  :image="location.image"
                  :caption="location.alt"
                  :title="location.name"
                  :subtitle="location.address"
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
            <li v-for="location in data" :key="location.id">
              <Summary
                :icon="icons[location.type]"
                :link="location.link"
                :image="location.image"
                :caption="location.alt"
                :title="location.name"
                :subtitle="location.address"
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
import {
  BIconBuildingFill,
  BIconCalendarEventFill,
  BIconPinMapFill,
} from "bootstrap-icons-vue";
import Summary from "./Summary.vue";
import { withDefaults, defineProps, reactive, ref } from "vue";
import { useFetch } from "@vueuse/core";
import { useUrl } from "../util";

const props = withDefaults(
  defineProps<{
    lat?: number;
    lng?: number;
    zoom?: number;
    noCurrent?: boolean;
    hotelId?: number;
    eventId?: number;
    placeId?: number;
  }>(),
  {
    lat: 17.0911074,
    lng: 121.7632927,
    zoom: 15,
    noCurrent: false,
    hotelId: 0,
    eventId: 0,
    placeId: 0,
  }
);

const icons = {
  hotel: BIconBuildingFill,
  event: BIconCalendarEventFill,
  place: BIconPinMapFill,
};

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

const pinMarker = L.icon({
  iconUrl: require("../assets/images/pin-icon.png"),
  iconRetinaUrl: require("../assets/images/pin-icon-2x.png"),
  iconSize: [25, 32],
  iconAnchor: [12, 32],
  popupAnchor: [0, -28],
});

const params = reactive({
  lng0: "",
  lng1: "",
  lat0: "",
  lat1: "",
  hotel_id: props.hotelId.toString(),
  place_id: props.placeId.toString(),
  event_id: props.eventId.toString(),
});
const url = useUrl("/api/hotel-area.php", params, [
  "checkin",
  "checkout",
  "n_adult",
  "n_child",
  "n_room",
]);
const { data, statusCode } = useFetch(url, {
  refetch: true,
  immediate: false,
})
  .get()
  .json<
    {
      id: number;
      type: "event" | "place" | "hotel";
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
  params.lat0 = bounds.getNorth().toString();
  params.lat1 = bounds.getSouth().toString();
  params.lng0 = bounds.getEast().toString();
  params.lng1 = bounds.getWest().toString();
}
</script>
<style scoped>
:deep(.leaflet-control-zoom) {
  border: 1px solid var(--gray-400) !important;
  margin: 0 1rem 1rem 0 !important;
  border-radius: 8px;
}

:deep(.leaflet-control-zoom a:first-child) {
  border-radius: 8px 8px 0 0 !important;
}

:deep(.leaflet-control-zoom a:last-child) {
  border-radius: 0 0 8px 8px !important;
  border-bottom: none;
}

:deep(.leaflet-control-zoom a) {
  color: var(--accent-color);
  border-bottom: 1px solid var(--gray-400);
  font-weight: 400;
}
</style>
