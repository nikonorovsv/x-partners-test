export default {
  methods: {
    formatMoney(val, annually = false) {
      if (val == 0) {
        return val;
      }

      if ( annually ) {
        val = val * 12;
      }
      return parseFloat(val).toFixed(2);
    }
  }
}