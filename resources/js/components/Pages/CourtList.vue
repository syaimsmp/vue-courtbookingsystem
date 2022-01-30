<template>

<div class="panel panel-default">
  <div class="panel-heading">
        Available Courts For:
        <input class="form-control" type="date" id="dateBooking" v-model="form.date" >
  </div>
    <div class="panel-body">
        <table class="table">
            <thead>
                <tr>
                        <th>No.</th>
                        <th>Courts</th>
                        <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="(court, index) in courts" :key="court.id" >
                    <td> {{ index+1 }} </td>
                    <td> {{ court.name }} </td>
                    <td>
                        <div v-if="court.approved != null">
                            <button v-if="court.approved == 0" type="button" @click="updateBooking(court.id, 1)" class="btn btn-success">Approve</button>
                            <button v-else type="button" @click="updateBooking(court.id, 0)" class="btn btn-danger">Reject</button>
                        </div>
                        <div v-else>
                            <button type="button" @click="bookCourt(court.id)" class="btn btn-primary">Book Now</button>
                        </div>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>

</template>

<script>
export default {
    data(){
        return {
            courts: [],
            form: {
                user_id: this.$user.id,
                user_role: this.$user.role_id,
                court_id: '',
                approved: 0,
                date: new Date().toJSON().slice(0,10),
            },
        }
    },
    created(){
        this.fetch()
    },
    methods:{
        async fetch(){
            console.log(this.$user)
            await this.axios
                .get('/booking', {params: this.form})
                .then(res => {
                    this.courts = res.data;
                });
            // console.log(this.courts);
        },
        async bookCourt(court_id){
            this.form.court_id = court_id
            await this.axios
                .post('/booking', this.form)
                .then(res => {
                    this.courts = res.data;
                    console.log(res)
                })
                .catch(err => console.log(err));

                // this.fetch()
        },

        async updateBooking(id, status){
            this.form.approved = status
            await this.axios
                .put('/booking/' + id, this.form)
                .then(res => {
                    this.courts = res.data;
                    console.log(res)
                })
                .catch(err => console.log(err));

                // this.fetch()
        }
    },
    watch:{
        "form.date": function(){
            this.fetch()
        },
    },
}
</script>
