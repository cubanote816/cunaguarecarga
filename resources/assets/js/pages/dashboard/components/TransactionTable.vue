<template>
  <el-table :data="list" style="width: 100%;padding-top: 15px;">
    <el-table-column label="Order_No" min-width="200">
      <template slot-scope="scope">
        {{ scope.row.phone | orderNoFilter }}
      </template>
    </el-table-column>
    <el-table-column label="Price" width="195" align="center">
      <template slot-scope="scope">
        ¥{{ scope.row.cost | toThousandFilter }}
      </template>
    </el-table-column>
    <el-table-column label="Status" width="100" align="center">
      <template slot-scope="scope">
        <el-tag :type="scope.row.status | statusFilter"> {{ scope.row.status }}</el-tag>
      </template>
    </el-table-column>
  </el-table>
</template>

<script>

import { mapActions, mapState } from 'vuex'

export default {
  filters: {
    statusFilter (status) {
      const statusMap = {
        success: 'success',
        pending: 'danger'
      }
      return statusMap[status]
    },
    orderNoFilter (str) {
      return str.substring(0, 30)
    }
  },
  data () {
    return {
      list: null
    }
  },
  computed: {
    ...mapState({
      reports: state => state.report.reports,
    }),
  },
  created () {
    this.fetchData()
  },
  methods: {
    ...mapActions([
      // 'sellersList',
      'reportsList',
    ]),
    fetchData () {
      this.reportsList()
    }
  }
}
</script>
