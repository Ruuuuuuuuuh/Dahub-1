<template>
  <v-card elevation="2" outlined color="grey" class="mx-auto">
    <v-list-item>
      <v-row>
        <v-col md="4"> logo 1 </v-col>
        <v-col md="4" class="mr-2"> logo 2</v-col>
      </v-row>
    </v-list-item>
    <v-spacer/>
    <v-list-item>
        <h3> {{cardholder_number}} </h3>
    </v-list-item>
    <v-list-item>
        <h3> {{cardholder_name}} </h3>
    </v-list-item>

  </v-card>
</template>

<script>
export default {
  props: ['cardholder_name', 'cardholder_number', 'card_type', 'card_provider']
}
</script>

<style>
</style>
