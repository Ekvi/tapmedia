<template>
    <div class="panel panel-default">
        <div class="panel-heading">
            <div class="row">
                <div class="col-md-1">Search:</div>
                <div class="col-md-2">
                    <select class="form-control" v-model="query.searchColumn">
                        <option v-for="column in columns" :value="column">{{column}}</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <input type="text"
                               class="form-control"
                               placeholder="Search"
                               v-model="query.searchInput"
                               @keyup.enter="fetchClicks()">
                    </div>
                </div>
                <div class="col-md-1">
                    <button class="btn btn-primary" @click="fetchClicks()">Search</button>
                </div>
            </div>
        </div>
        <div class="panel-body">
            <div class="table-responsive">
                <div class="table-responsive">
                    <table class="table table-striped table-bordered table-hover">
                        <thead>
                        <tr>
                            <th v-for="column in columns" @click="toggleOrder(column)">
                                {{column}}
                                <span class="dv-table-column" v-if="column === query.column">
                                    <span v-if="query.direction === 'desc'">&darr;</span>
                                    <span v-else>&uarr;</span>
                                </span>
                            </th>
                            <th>Delete</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr v-for="click in clicks">
                            <td>{{click.id}}</td>
                            <td>{{click.ip}}</td>
                            <td>{{click.ua}}</td>
                            <td>{{click.ref}}</td>
                            <td>{{click.param1}}</td>
                            <td>{{click.param2}}</td>
                            <td>{{click.error}}</td>
                            <td>{{click.bad_domain}}</td>
                            <td @click.prevent="deleteClick(click.id)">
                                <a href="#" role="button"><i class="fa fa-close fa-2x"></i></a>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="panel-footer"></div>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                clicks: [],
                columns: [],
                query: {
                    column: 'id',
                    direction: 'desc',
                    searchColumn: 'id',
                    searchInput: ''
                },
            }
        },
        mounted() {
            this.fetchClicks('id', 'desc');
        },
        methods: {
            toggleOrder(column) {
                if(column === this.query.column) {
                    if(this.query.direction === 'desc') {
                        this.query.direction = 'asc';
                    } else {
                        this.query.direction = 'desc';
                    }
                } else {
                    this.query.column = column;
                    this.query.direction = 'asc';
                }

                this.fetchClicks();
            },
            fetchClicks() {
                this.$http.get(`/clicks/get?column=${this.query.column}&direction=${this.query.direction}&searchColumn=${this.query.searchColumn}&searchInput=${this.query.searchInput}`)
                        .then(response =>  {
                            this.clicks = response.data.clicks;
                            this.columns = response.data.columns;
                        });
            },
            deleteClick(id) {
                this.$http.delete(`/click/${id}/delete`)
                        .then(response =>  {
                            for(let i = 0; i < this.clicks.length ;i++) {
                                if(this.clicks[i].id == response.data.id) {
                                    this.clicks.splice(i, 1);
                                    break;
                                }
                            }
                        });
            }
        }
    }
</script>
