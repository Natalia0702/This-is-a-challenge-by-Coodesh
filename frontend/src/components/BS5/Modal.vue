<template>
  <!-- <div class="item">
    <i>
      <slot name="icon"></slot>
    </i>
    <div class="details">
      <h3>
        <slot name="heading"></slot>
      </h3>
      <slot></slot>
    </div>
  </div> -->

    <div
        v-if="showModal"
        class="modal fade -show"
        v-bind:class="{
            show: props.open,
        }"
        id="exampleModalLive"
        tabindex="-1"
        aria-labelledby="exampleModalLiveLabel"
        style="display: block; background: #00000012;"
        aria-modal="true"
        role="dialog"
    >
        <div class="modal-dialog">
            <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLiveLabel">
                    <slot name="heading"></slot>
                </h1>
                <!-- <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button> -->
            </div>
            <div class="modal-body">
                <slot></slot>
            </div>
            <div class="modal-footer">
                <slot name="modal_footer"></slot>
            </div>
            </div>
        </div>
    </div>
</template>
<style scoped></style>

<script setup>
import { ref, onMounted } from 'vue'
import { toBool } from '@/helpers/casts'
const props = defineProps({
    open: {
        default: false,
    }
});
let showModal = ref(toBool(props.open));

console.log('showModal', showModal.value)

const closeModal = () => {
    console.log('showModal', showModal.value)
    showModal.value = 0;
    console.log('showModal', showModal.value)
}

onMounted((() => {
    let selector = 'input.flatpickr-input-date, [date-flatpickr]';
    document.querySelectorAll(selector)?.forEach(dateInput => {
        if (!dateInput) {
            return;
        }

        !dateInput.getAttribute('placeholder') && dateInput.setAttribute('placeholder', 'd/m/Y');

        dateInput ? flatpickr(dateInput, {
            altInput: true,
            altFormat: "d/m/Y",
            dateFormat: "Y-m-d",
            ariaDateFormat: "d/m/Y",
            locale: "pt",
            // mode: 'range',
        }) : null; // flatpickr
    });
}))
// flatpickr.localize(flatpickr.l10ns.ru);
// flatpickr.l10ns.pt
</script>
