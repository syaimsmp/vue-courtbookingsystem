<template>

<div class="panel panel-default">
  <div class="panel-heading">
        Booking List:
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
                        <button type="button" @click="bookCourt(court.id)" class="btn btn-primary">Book Now</button>
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
                user_id: this.$userId,
                court_id: '',
                date: new Date().toJSON().slice(0,10),
            },
        }
    },
    created(){
        this.fetch()
    },
    methods:{
        async fetch(){
            await this.axios
                .get('/api/booking', {params: this.form})
                .then(res => {
                    this.courts = res.data;
                });
            // console.log(this.courts);
        },
        async bookCourt(court_id){
            this.form.court_id = court_id
            await this.axios
                .post('/api/booking', this.form)
                .then(res => {
                    this.courts = res.data;
                    console.log(res)
                })
                .catch(err => console.log(err));

                this.fetch()
        }
    },
    watch:{
        "form.date": function(){
            this.fetch()
        },
    },
}
</script>
