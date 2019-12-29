<template>
    <div>
        <div class="row pt-5">
            <div class="col-md-12 text-center pt-5">
                <h1>{{this.timer}}</h1>
                <b-progress :max="max" height="2rem" :striped="true" show-progress :animated="true">
                    <b-progress-bar :value="value" variant="success">
                        <h5 v-if="value > 0">Loading</h5>
                    </b-progress-bar>
                </b-progress>
                <!--<b-progress height="2rem" variant="success" :value="value" show-progress class="mb-2"></b-progress>-->
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                timer: 0,
                value: 0,
                max: 180
            };
        },
        mounted() {
            this.startTimer();
        },
        methods: {
            startTimer() {
                let vm = this;
                let timer = setInterval(function() {
                    vm.value += 6;
                    if (vm.value >= 180) clearInterval(timer);
                }, 100);
            }
        }
    };
</script>

<style scoped>
</style>
