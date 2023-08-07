<template>
    <Field as="hidden" :name="name" />
  </template>

  <script>
  import { Field } from "vee-validate";

  export default {
    name: "HiddenField",
    props: {
      name: {
        type: String,
        required: true,
      },
    },
    components: {
      Field,
    },
  };
  </script>
