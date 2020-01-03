<template>
    <div>
        <CRow>
            <CCol sm="12">
                <template v-if="loading">
                    <c-spinner/>
                </template>
                <template v-else>
                    <CDataTable
                            :items="items"
                            :fields="fields"
                            column-filter
                            table-filter
                            items-per-page-select
                            hover
                            sorter
                            pagination
                    >
                        <template #status="{item}">
                            <td>
                                <CBadge :color="getBadge(item.status)">
                                    {{item.status}}
                                </CBadge>
                            </td>
                        </template>
                        <template #show_details="{item, index}">
                            <td class="py-2">
                                <CButton
                                        color="primary"
                                        variant="outline"
                                        square
                                        size="sm"
                                        @click="toggleDetails(index)"
                                >
                                    {{details.includes(index) ? 'Hide' : 'Show'}}
                                </CButton>
                            </td>
                        </template>
                        <template #details="{item, index}">
                            <CCollapse :show="details.includes(index)">
                                <CCardBody>
                                    {{index + 1}} - {{item}}
                                </CCardBody>
                            </CCollapse>
                        </template>
                    </CDataTable>
                </template>
            </CCol>
        </CRow>
    </div>
</template>

<script>
    import * as HH from 'house_hold/src/index';

    const fields = [
        {key: 'name', _style: 'width:40%'},
        {key: 'inStock', _style: 'width:20%;'},
        {key: 'bestBefore', _style: 'width:20%;'},
        {
            key: 'show_details',
            label: '',
            _style: 'width:1%',
            sorter: false,
            filter: false
        }
    ];

    export default {
        name: 'InStock',
        data() {
            return {
                loading: true,
                items: [],
                fields,
                details: []
            }
        },
        created() {
            this.getInStockItems();
        },
        methods: {
            getBadge(status) {
                return status === 'Active' ? 'success'
                    : status === 'Inactive' ? 'secondary'
                        : status === 'Pending' ? 'warning'
                            : status === 'Banned' ? 'danger' : 'primary'
            },
            toggleDetails(index) {
                const position = this.details.indexOf(index);
                position !== -1 ? this.details.splice(position, 1) : this.details.push(index)
            },
            getInStockItems() {
                const productApi = new HH.ProductApi();
                const stockApi = new HH.ProductStockApi();
                let results = [];
                productApi.getProductCollection()
                    .then((data) => {
                        data = data['hydra:member'];

                        data.forEach((item, index) => {
                            let quantityApiCalls = item['stocks'].map((stockId) => {
                                return stockApi.getProductStockItem(/[^/]*$/.exec(stockId)[0])
                                    .then((stockItem) => {
                                        return {total: stockItem['quantity']};
                                    });
                            });

                            Promise.all(quantityApiCalls).then((quantity) => {
                                let totalQuantity = 0;
                                quantity.forEach((obj) => {
                                    totalQuantity += obj.total;
                                });


                                let result = {
                                    name: item['name'],
                                    ean: item['ean'],
                                    price: item['price'],
                                    expiring: item['expiring'],
                                    bestBefore: (new Date(item['bestBefore'])).toLocaleDateString(),
                                    collection: item['collection'],
                                    location: item['location'],
                                    inStock: totalQuantity,
                                    stocks: item['stocks'],
                                    id: item['id']
                                };

                                results.push(result);
                            });
                        });
                    }).then(() => {
                    this.items = results || [];
                    this.loading = false;
                });
            }
        }
    }
</script>
