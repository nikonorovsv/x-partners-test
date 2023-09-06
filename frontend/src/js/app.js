import { createApp } from "vue/dist/vue.esm-bundler.js";
import store from "./store";
import config from "../js/config";

import FormAddRealEstateObject from "./components/FormAddRealEstateObject.vue";

// Register Apps
const apps = [
  {
    name: "FormAddRealEstateObject",
    component: FormAddRealEstateObject,
    useStore: false,
    useConfig: false,
  }
];

// Init Apps
apps.forEach((item) => {
  const $els = document.querySelectorAll(`[data-component="${item.name}"]`);

  if ($els instanceof NodeList) {
    $els.forEach(($el) => {
      if (!($el instanceof HTMLDivElement)) {
        return;
      }

      let props;

      // For local props
      if (item.props) {
        props = item.props;
      }

      // For backend props
      if ($el.hasAttribute("data-props")) {
        const propsJSON = $el.getAttribute("data-props");
        props = {
          ...props,
          ...JSON.parse(propsJSON),
        };

        $el.removeAttribute("data-props");
      }

      const app = createApp(item.component, props);

      // Provide global variables
      if (item.useConfig) {
        item.useConfig.forEach((propName) => {
          app.config.globalProperties[propName] = config[propName];
        });
      }

      // Use Store
      if (item.useStore) {
        app.use(store);
      }

      app.mount($el);
    });
  }
});
