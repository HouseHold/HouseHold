<template>
    <CRow>
        <CCol sm="6" lg="3">
            <CButton class="stock-action-btn" size="lg" color="success" block>Add Stock</CButton>
        </CCol>
        <CCol sm="6" lg="3">
            <CButton class="stock-action-btn" size="lg" color="info" block>Show Bellow Limit</CButton>
        </CCol>
        <CCol sm="6" lg="3">
            <CButton class="stock-action-btn" size="lg" color="warning" block>Show Expiring</CButton>
        </CCol>
        <CCol sm="6" lg="3">
            <CButton class="stock-action-btn" size="lg" color="danger" block>Show Expired</CButton>
        </CCol>
    </CRow>
</template>

<script>
    export default {
        name: 'WidgetsStockActions'
    }
</script>

<style scoped>
    .stock-action-btn {
        margin-bottom: 10px;
    }
</style>
