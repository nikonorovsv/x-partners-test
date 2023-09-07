<template>
  <div v-if="urlCreated">
    <p class="mb-5">Объект успешно создан!</p>
    <div class="d-flex justify-content-center">
      <a :href="urlCreated" class="btn btn-success mr-5">Просмотреть объект</a>
      <button @click="recreateForm()" class="btn btn-primary">Добавить новый объект</button>
    </div>
  </div>

  <v-form
      @submit="sendForm"
      :validation-schema="schema"
      v-slot="{ errors }"
      v-else
  >
    <div class="form-group">
      <label for="objectPostTitle">Название</label>
      <v-field
          id="objectPostTitle"
          class="form-control"
          :class="errors.name ? 'is-invalid' : null"
          name="name"
          placeholder="Например: 2-к. квартира, 44 м², 29/34 эт."
          type="text"
      />
      <v-error
          :message="errors.name ? errors.name : 'Кратко и ёмко опишите объект.'"
          :classes="errors.name ? 'text-danger' : 'text-muted'"
      />
    </div>
    <div class="form-group">
      <label for="objectPostDesc">Описание</label>
      <v-field v-slot="{ field, error }" name="desc">
        <textarea id="objectPostDesc" v-bind="field" class="form-control" :class="error ? 'is-invalid' : null" rows="3" />
      </v-field>
      <v-error
          :message="errors.desc ? errors.desc : null"
          :classes="errors.desc ? 'text-danger' : 'text-muted'"
      />
    </div>
    <div class="form-row">
      <div class="col">
        <div class="form-group">
          <label for="objectArea">Общая площадь (кв.м)</label>
          <v-field
              id="objectArea"
              class="form-control"
              :class="errors.area ? 'is-invalid' : null"
              name="area"
              type="number"
              step="0.1"
              min="0"
          />
          <v-error
              :message="errors.area ? errors.area : null"
              :classes="errors.area ? 'text-danger' : 'text-muted'"
          />
        </div>
      </div>
      <div class="col">
        <div class="form-group">
          <label for="objectLivingArea">Жилая площадь (кв.м)</label>
          <v-field
              id="objectLivingArea"
              class="form-control"
              :class="errors.living_area ? 'is-invalid' : null"
              name="living_area"
              type="number"
              step="0.1"
              min="0"
          />
          <v-error
              :message="errors.living_area ? errors.living_area : null"
              :classes="errors.living_area ? 'text-danger' : 'text-muted'"
          />
        </div>
      </div>
    </div>

    <div class="form-row">
      <div class="form-group col-md-9 col-sm-7">
        <label for="objectAddress">Адрес</label>
        <v-field
            id="objectAddress"
            class="form-control"
            :class="errors.address ? 'is-invalid' : null"
            name="address"
            placeholder="Например: Москва, Авиационная ул., 66"
            type="text"
        />
        <v-error
            :message="errors.address ? errors.address : 'Начиная с названия города.'"
            :classes="errors.address ? 'text-danger' : 'text-muted'"
        />
      </div>
      <div class="form-group col-md-3 col-sm-5">
        <label for="objectFloor">Этаж</label>
        <v-field
            id="objectFloor"
            class="form-control"
            :class="errors.floor ? 'is-invalid' : null"
            name="floor"
            type="number"
            min="1"
        />
        <v-error
            :message="errors.floor ? errors.floor : null"
            :classes="errors.floor ? 'text-danger' : 'text-muted'"
        />
      </div>
    </div>

    <div class="form-group">
      <label for="objectPrice">Цена (руб.)</label>
      <v-field
          id="objectPrice"
          class="form-control"
          :class="errors.price ? 'is-invalid' : null"
          name="price"
          type="number"
          step="1000"
          min="0"
      />
      <v-error
          :message="errors.price ? errors.price : null"
          :classes="errors.price ? 'text-danger' : 'text-muted'"
      />
    </div>

    <button type="submit" class="btn btn-primary">Загрузить объект в базу</button>
  </v-form>
</template>

<script>
import WPAjax from '../libs/WPAjax'
import { defineRule, configure, Field, Form } from 'vee-validate'
import { required, min_value, max_value } from '@vee-validate/rules'
import { localize } from '@vee-validate/i18n'
//import mitt from 'mitt'

import FormErrorMessage from './FormErrorMessage.vue'

defineRule('required', required)
defineRule('min_value', min_value)
defineRule('max_value', max_value)

configure({
  // Generates an English message locale generator
  generateMessage: localize('en', {
    messages: {
      required: 'Поле обязательно для заполнения.',
      min_value: 'Неверное значение.',
      max_value: 'Неверное значение.',
    },
  }),
  validateOnBlur: false,
  validateOnChange: false,
  validateOnInput: false,
  validateOnModelUpdate: false,
})

// const emitter = mitt()
export default {
  components: {
    VForm: Form,
    VField: Field,
    VError: FormErrorMessage,
  },

  props: {
    nonce: String,
    author: Number,
  },

  data() {
    return {
      urlCreated: null,
      schema: {
        name: {
          required: true,
        },
        desc: {
          required: true,
        },
        area: {
          required: true,
          min_value: 0,
        },
        living_area: {
          required: true,
          min_value: 0,
        },
        address: {
          required: true,
        },
        floor: {
          required: true,
          min_value: 1,
          max_value: 100,
        },
        price: {
          required: true,
          min_value: 0
        }
      },
    }
  },

  methods: {
    async sendForm(formData, { resetForm }) {
      const ajax = new WPAjax('real-estate-object', 'create', this.nonce)
      await ajax.load({
        payload: {
          ...formData,
          author: this.author
        },
        onSuccess: (res) => {
          this.urlCreated = res.url;

          resetForm()
        },
      });
    },

    recreateForm() {
      this.urlCreated = null;
    },
  }
}
</script>