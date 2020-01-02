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
    const fields = [
        {key: 'product', _style: 'width:40%'},
        {key: 'amount', _style: 'width:20%;'},
        {key: 'best_before', _style: 'width:20%;'},
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
                this.loading = false;
                this.items = [{product: "Test Product", amount: 22, best_before: "2020-11-04T19:55:41Z"}];
            }
        }
    }
</script>
