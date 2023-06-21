<template>
  <CFooter>
    <!-- <div class="mx-auto">Copyright &copy; {{ currentYear }} CO-WELL Asia</div> -->
  </CFooter>
</template>

<script>
export default {
  name: 'AppFooter',
  data() {
    const currentYear = new Date().getFullYear();
    return { currentYear };
  }
}
</script>
