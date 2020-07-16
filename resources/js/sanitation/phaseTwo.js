const BASE_URL = "http://localhost/mdc/public";

console.log('test phase 2 js'); // just to make sure phase2 scripts was loaded.

new Vue({
  el: '#sanitationPhaseTwo-container',
  data() {
  	return {
      //variables here
      dataToBeSanitized : [],
      charToRemove : ["]DR ","]R ","]RA ","`DR ","`DRA ","`R ","DR ","DR  ","D   ","DR A ","DR DR ","DR. ","DR.","DR/ ","DR] ","DR]","DRA  ","MD "," JR"," SR"],
      charToRemove1 : ["DR. ", "Dr ", "DR. "],
      sanitationLabel : '',
      getByDoctorName: [], //holding of each MD.
      sanitationCount : 0,
      getByDoctorNameIndex: 0,
      getByDoctorNameFoundLogsCount : 0,
      getByDoctorNameCount :0,
      getByDoctorNamePercentage: 0,
      sanitationBtn : false,
      getByDoctorNameFoundLogs: '',
      getByDoctorNameDuplicateLogsCount: 0,
      getByDoctorNameLogs : '',
      getDoctorNameFound : [],



  	}
  },
  updated() {
  //functions to be updated everytime there's a changes
  document.getElementById('sanitationLogs').scrollTop = document.getElementById('sanitationLogs').scrollHeight;
  },
  methods: {
    //methods here
    sanitizeNow : function (){
   
      this.sanitationLabel = 'Scanning.... ';

      axios
      .get(`${BASE_URL}/sanitation/get-all-md`)
      
      .then((response) => {

        this.dataToBeSanitized = response.data
        this.sanitationLabel = 'Totalllll.... ';
        this.sanitationCount = this.dataToBeSanitized.length;


        let rawId = this.dataToBeSanitized[this.getByDoctorNameIndex].raw_id;
        let rawDoctor = this.dataToBeSanitized[this.getByDoctorNameIndex].raw_doctor;

        this.getByMdName(rawId, rawDoctor);
      })

      .catch((error) =>{
        console.log(error);
      })

   
    },//end of sanitize now

    getByMdName : function(rawId, mdName){
      
      let firstName;
      let lastName;
      let fullSplit;

      fullSplit = mdName.split(" ");
      
      if(fullSplit.length >= 3 ){
        fullSplit.shift();
        firstName = fullSplit[0];
        lastName = fullSplit[fullSplit.length - 1];
      } else{
        firstName = fullSplit[0];
        lastName = fullSplit[fullSplit.length - 1];
      }

      let data = {
        rawId : rawId,
        mdName: mdName,
        firstName : firstName,
        lastName : lastName,
      }
      console.log(mdName);
      console.log(firstName);
      console.log(lastName);

      axios
      .post(`${BASE_URL}/sanitation/phase-two/get-single-md`, data)
      
      .then((response) => {
        console.log("Response : " + lastName);
        
        this.getByDoctorName = response.data;
        this.sanitationLabel = "Phase 2 done!";

        //do we have MD or Doctors?
        //check
        if(this.getByDoctorName.length > 0) {

          //only have 1 data
          if(this.getByDoctorName.length === 1) {

            //left logs that shows the BLUE font when found an MD
					this.getByDoctorNameLogs += `
					<span style="font-size:13px;">
						(${this.dataToBeSanitized[this.getByDoctorNameIndex].raw_id}) ${this.dataToBeSanitized[this.getByDoctorNameIndex].raw_doctor}
						-
						<span style="color:blue;">(${this.getByDoctorName.length}) FOUND</span>
					<span>
          <br>`;

          //right logs
					this.getByDoctorNameFoundLogs += `
					<span style="font-size:13px;">
						<span style="color: red; ">
							(${this.dataToBeSanitized[this.getByDoctorNameIndex].raw_id}) ${this.dataToBeSanitized[this.getByDoctorNameIndex].raw_doctor}
						</span>
						<br>
						<span style="color: blue">
							(${this.getByDoctorName[0].sanit_id}) ${this.getByDoctorName[0].sanit_mdname} |
							${this.getByDoctorName[0].sanit_universe} |
							${this.getByDoctorName[0].sanit_group}
						</span>
					</span>
					<br>----------------------------------<br>
          `;
          
            this.getByDoctorNameFoundLogsCount += 1;

          let rawId = this.dataToBeSanitized[this.getByDoctorNameIndex].raw_id;
					let group = this.getByDoctorName[0].sanit_group;
					let mdName = this.getByDoctorName[0].sanit_mdname;
					let universe = this.getByDoctorName[0].sanit_universe;
					let mdCode = this.getByDoctorName[0].sanit_id;


					this.updateNow(rawId, group, mdName, universe, mdCode);
          } else{
            this.getByDoctorNameFoundLogs += `
						<span style="font-size:13px; color:red;">
							${this.dataToBeSanitized[this.getByDoctorNameIndex].raw_doctor} - (${this.getByDoctorName.length}) FOUND
							<i>ignoring, fix the duplicates first for this keyword</i>
						</span>
						<br>----------------------------------<br>`;
					this.getByDoctorNameDuplicateLogsCount += 1;
            this.getByDoctorNameDuplicateLogsCount += 1;
          }
        }
       

        //proceed to next doctor
        if( this.sanitationCount !== this.getByDoctorNameIndex ) {
        
        this.getByDoctorNameCount += 1;
        this.getByDoctorNamePercentage = ((this.getByDoctorNameCount / this.sanitationCount) * 100).toFixed(2);
        
        //left logs, MD's not found.
				if(this.getByDoctorName.length < 1) {
					//left logs
					this.getByDoctorNameLogs += `<span style="font-size:13px;">(${this.dataToBeSanitized[this.getByDoctorNameIndex].raw_id}) ${this.dataToBeSanitized[this.getByDoctorNameIndex].raw_doctor}</span><br>`;
				}


          this.getByDoctorNameIndex += 1;

          if(typeof this.dataToBeSanitized[this.getByDoctorNameIndex] !== 'undefined') {
            this.getByMdName(this.dataToBeSanitized[this.getByDoctorNameIndex].raw_id, this.dataToBeSanitized[this.getByDoctorNameIndex].raw_doctor);
            this.sanitationBtn = true;
          }else {
            // this.sanitationBtn = false;
          }
        }

       
      })
      
      .catch((error) =>{
        console.log(error);
      }) 
    
    },

    updateNow : function(rawId, group, mdName, universe, mdCode){
    let data = {
  			rawId: rawId,
  			group: group,
  			mdName: mdName,
  			universe: universe,
  			mdCode: mdCode
  		}
      axios
      .post(`${BASE_URL}/sanitation/phase-two/get-single-md/sanitize`, data, {
  			headers:{
  				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
  			}
  		})
      .then((response) => {

      })
      .catch( (error) =>{
       /*  console.log(error); */
      })
    },
    
  } // end of methods
});