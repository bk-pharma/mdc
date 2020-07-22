new Vue({
  el: '#sanitationPhaseFour-container',
  data() {
  	return {
      //variables here
    dataToBeSanitized : [],
    getByDoctorIndex: 0,
    sanitationLabel:'',
    sanitationCount: 0,
    sanitizedByDoctorNamePercentage: 0,
    leftLogs:'',
    rightLogs: '',
    foundMD:[],
    totalFound: 0,


  	}
  },
  updated() {
  //functions to be updated everytime there's a changes
  document.getElementById('leftLogsPhaseFour').scrollTop = document.getElementById('leftLogsPhaseFour').scrollHeight;
  },
  methods: {
    //methods here
    startSanitize : function (){

      this.sanitationLabel = 'Scanning.... ';

      axios.get(`get-all-md`)

      .then((response) => {

        this.dataToBeSanitized = response.data;
        this.sanitationCount = this.dataToBeSanitized.length;

        let rawId = this.dataToBeSanitized[this.getByDoctorIndex].raw_id;
        let md = this.dataToBeSanitized[this.getByDoctorIndex].raw_doctor;
        let rawBranch = this.dataToBeSanitized[this.getByDoctorIndex].raw_branchcode;

        this.sanitationLabel = md;


        this.getByMdName(rawId, md,  rawBranch);
      })

      .catch((error) =>{
        console.log(error);
      })

    },//end of sanitize now

    getByMdName : function(rawId, mdName, rawBranch){
      this.sanitationLabel = `${mdName}`;
      let data = {
        rawId : rawId,
        mdName: mdName,
        rawBranch : rawBranch,
      }

      axios.post(`phase-four/get-single-md`, data)

      .then((response) => {

        this.foundMD = response.data;
        this.sanitationLabel = 'Phase 4 done.';

        if(this.foundMD.length > 0) {
          console.log('1');
          this.leftLogs += `
            <span style="font-size:13px;">
              (${this.dataToBeSanitized[this.getByDoctorIndex].raw_id}) ${this.dataToBeSanitized[this.getByDoctorIndex].raw_doctor}
                -
              <span style="color:blue;">(${this.foundMD.length}) FOUND</span>
            </span>
            <br>`;

          this.rightLogs += `
            <span style="font-size:13px;">
              <span style="color:red;">(${this.dataToBeSanitized[this.getByDoctorIndex].raw_id}) ${this.dataToBeSanitized[this.getByDoctorIndex].raw_doctor}</span>
              <br>
              <span style="color:blue;">(${this.foundMD[0].sanit_id}) ${this.foundMD[0].sanit_mdname}</span>
              <br>----------------------------------<br>
            </span>
            `;


          this.totalFound += 1;
        }else {
          console.log('2');

          this.leftLogs += `
          <span style="font-size:13px;">
            (${this.dataToBeSanitized[this.getByDoctorIndex].raw_id}) ${this.dataToBeSanitized[this.getByDoctorIndex].raw_doctor}
          </span>
          <br>
          `;

        }

        this.getByDoctorIndex += 1;
        this.sanitizedByDoctorNamePercentage = ((this.getByDoctorIndex / this.sanitationCount) * 100).toFixed(2);


        if(this.getByDoctorIndex < this.dataToBeSanitized.length) {

          let rawId = this.dataToBeSanitized[this.getByDoctorIndex].raw_id;
          let md = this.dataToBeSanitized[this.getByDoctorIndex].raw_doctor;
          let rawBranch = this.dataToBeSanitized[this.getByDoctorIndex].raw_branchcode;

          this.sanitationLabel = md;

          this.getByMdName(rawId, md, rawBranch);
        }
      })

      .catch((error) =>{
        console.log(error);
      })

    },
  } // end of methods
});