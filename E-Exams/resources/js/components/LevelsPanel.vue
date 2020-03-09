<template>
<div class="container">
    <b-alert
        :show="dismissCountDown"
        dismissible
        fade
        :variant="alert"
        @dismiss-count-down="countDownChanged"
    >

        {{message}}
    </b-alert>
    <div class="row justify-content-end mr-5 mb-4">
        <button class="btn btn-primary" @click="showAddLevelModal()">Add Level</button>
    </div>
    <b-table
        striped
        hover
        :items="levels"
        :fields="fields"
        :sticky-header="true"
        :busy="isBusy"
    >
        <template v-slot:table-busy>
            <div class="text-center text-danger my-2">
                <b-spinner class="align-middle"></b-spinner>
                <strong>Loading...</strong>
            </div>
        </template>
        <template v-slot:cell(actions)="row">
                <button class="btn btn-primary" @click="showDepartmentsModal(row)">Departments</button>
        </template>
    </b-table>
<!--    Add New Level Modal-->
    <b-modal
        id="modal-prevent-closing"
        ref="newLevelModal"
        title="Add New Modal"
        @ok="handleOkForNewLevelModal"
    >
        <form ref="form" @submit.stop.prevent="handleSubmitForNewLevelModal" autocomplete="off">
            <b-form-group
                :state="levelTitleState"
                label="Level Title"
                label-for="level-title-input">
                <b-form-input
                    id="level-title-input"
                    autocomplete="off"
                    v-model="levelTitle"
                    :state="levelTitleState"
                    required
                ></b-form-input>
                <b-form-invalid-feedback :state="levelTitleState">
                    The english name length must be between 5 and 200 characters.
                </b-form-invalid-feedback>

            </b-form-group>
        </form>
    </b-modal>
<!--    show departments modal-->
<b-modal
    ref="showDeptModal"
    title="Departments in this level"
>
    <div class="row justify-content-end">
        <button class="btn btn-primary mr-4" @click="">Add Dept</button>
    </div>
    <ul>
        <li v-for="dept in level.departments" v-text="dept"></li>
    </ul>
</b-modal>

</div>
</template>

<script>
    export default {
        name: "LevelsPanel",
        mounted() {
            this.getLevels();
        },
        computed:{
            levelTitleState:function(){
                if(this.levelTitle.length===0)
                    return null;
                return this.levelTitle.length>5 && this.levelTitle.length<200 &&this.validateName(this.levelTitle);
            }
        },
        data:function(){
            return {
              levels:[],
              level:{},
                fields:['id','level','actions'],
                levelTitle:'',
                dismissSecs: 5,
                dismissCountDown: 0,
                message: "",
                alert: "danger",
                isBusy:false,
            };
        },
        methods:{
            getLevels(){
                var self=this;
                this.isBusy=true;
                axios.get('/level')
                    .then(response=>{
                        this.levels=response.data.data;
                    })
                    .catch(error=>console.log(error));
                setTimeout(function(){
                    if(self.levels.length===0)
                        self.showAlert('Sorry there is no levels');
                    self.isBusy=false;
                },3000);

            },
            validateName(name) {
                var re = /^[A-Za-z ]+$/;
                return re.test(name);
            },

            countDownChanged(dismissCountDown) {
                this.dismissCountDown = dismissCountDown;
                if (this.dismissCountDown === 0) {
                    this.message = "";
                    this.alert = "danger";
                }
            },
            showAlert(message='',alert='danger'){
              this.message=message;
              this.alert=alert;
                this.dismissCountDown = this.dismissSecs

            },
            //#region add new level modal
            showAddLevelModal(){
                this.levelTitle='';
                this.$refs.newLevelModal.show();
            },
            handleOkForNewLevelModal(bvModalEvt) {
                // Prevent modal from closing
                bvModalEvt.preventDefault();
                // Trigger submit handler

                this.handleSubmitForNewLevelModal();

            },
            handleSubmitForNewLevelModal(){
                if (!this.levelTitleState)
                    return
                this.sendNewLevel();
                this.$nextTick(() => {
                    this.$refs.newLevelModal.hide();
                })
            },
            sendNewLevel(){
              var data = new FormData();
              data.append('level_title',this.levelTitle);
              axios.post('/level',data)
                  .then(response=>{
                        if(response.data.success){
                            this.showAlert('New level is added','success');
                            this.getLevels();
                        }
                        else{
                            this.showAlert(response.data.errors.join('.'));
                        }
                  })
                  .catch(error=>console.log(error));
            },
            //#endregion
            //#region dept section
            showDepartmentsModal(level){
                this.level=level;
                this.$refs.showDeptModal.show();
            },

            //#endregion
        },

    }
</script>

<style scoped>

</style>
