<template>
  <v-container>
    <v-list-item>
      <v-list-item-content>
        <h2>Создать Заявку</h2>
      </v-list-item-content>
    </v-list-item>
    <v-list-item>
      <v-list-item-content>
        <h2>Создать Заявку 2</h2>
      </v-list-item-content>
    </v-list-item>
    <v-list-item>
      <v-list-item-content>
        <h2>Создать Заявку 3</h2>
      </v-list-item-content>
    </v-list-item>

    <v-list-item>
      <v-list-item-content>
        <v-subheader class="pl-0"> Комиссия </v-subheader>
        <v-slider inverse-label min="0" max="20"></v-slider>
      </v-list-item-content>
    </v-list-item>
  </v-container>
</template>

<script>
export default {
  name: "Home",
};
</script>

<style scoped>
</style>
