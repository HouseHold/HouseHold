<template>
    <div>
        <c-row>
            <CCol sm="8">
                <CCard>
                    <CCardHeader>
                        <strong>Add Product to Stock</strong>
                    </CCardHeader>
                    <CCardBody>
                        <CInput
                                label="Product"
                                placeholder="Enter product name"
                        />
                        <CInput
                                label="Best Before"
                                placeholder="Select best before"
                                type="date"
                        />
                        <CInput
                                label="Amount"
                                placeholder="Enter amount"
                        />
                        <CInput
                                label="Price"
                                placeholder="Enter price"
                        />
                        <CInput
                                label="Location"
                                placeholder="Select location"
                        />
                    </CCardBody>
                </CCard>
            </CCol>
        </c-row>
    </div>
</template>

<script>
    import WidgetsStock from './WidgetsStock'
    import InStock from "./table/InStock";
    import WidgetsActions from "./WidgetsActions";

    export default {
        name: 'StockPurchase',
        components: {
            WidgetsStock,
            WidgetsActions,
            InStock
        }
    }
</script>
