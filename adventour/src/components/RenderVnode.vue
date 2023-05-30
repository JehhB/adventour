<script lang="ts">
import { defineComponent } from "vue";
import type { PropType, VNode } from "vue";

export default defineComponent({
  props: {
    vnode: {
      required: true,
      type: Object as PropType<VNode | VNode[]>,
    },
  },
  setup(props) {
    return () => props.vnode;
  },
});
</script>
