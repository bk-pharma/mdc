new Vue({
    el: '#sanitation-container',
    data() {
        return {
           sanitationStatus : '',
           sanitationBtn: false,
           startTime:'',
           endTime:'',
           runTime:'',
           processRowStartArr: [],
           rowCount: 0,
           rowCountField: false,
           totalSanitizedRow: 0,
           percentageSanitizedRow: 0,
           totalUnsanitizedRow: 0,
           totalSanitizedAmount: 0,
           totalRaw: 0,
           totalSanitationProcess:  0,
           percentageSanitationProcess: 0,
           totalRun:0
        }
    },
    filters: {
        numberFormat: function(num)
        {
            if(num)
            {
                return num.toLocaleString();
            }else
            {
                return num;
            }
        },
        decimalFormat: function(num)
        {
            if(num || !isNaN(num))
            {
                return num.toFixed(2);
            }else
            {
                return num;
            }
        }
    },
      mounted() {
        if (localStorage.startTime) {
          this.startTime = localStorage.startTime;
        }
      },
    created()
    {
        this.initialData(false);
    },
    methods : {
        initialData:function(isSanitationRunning)
        {
            axios.get(`sanitation/sanitized-total`)
            .then((response) =>
            {
                let resp = response.data;
                this.rowCount = (resp.totalRaw - resp.totalSanitized);
                this.totalSanitizedRow = resp.totalSanitized;
                this.totalSanitizedAmount = resp.totalAmount;
                this.totalUnsanitizedRow = (resp.totalRaw - resp.totalSanitized);

                this.percentageSanitizedRow = (resp.totalSanitized / resp.totalRaw) * 100;

                if(resp.sanitationProcess > 0)
                {
                    this.sanitationStatus = 'Sanitation in process...';

                    /*
                        https://stackoverflow.com/questions/313893/how-to-measure-time-taken-by-a-function-to-execute
                     */
                    this.endTime = new Date().getTime();
                    this.runTime = this.convertToString(this.endTime - this.startTime);
                }else
                {
                    if(isSanitationRunning) {

                        this.totalRun += 1;

                        if(this.totalRun < 4)
                        {
                            this.sanitationProcess();
                        }else
                        {
                            this.sanitationStatus = 'Sanitation done.';
                            this.rowCountField =  false;
                            this.sanitationBtn = false;
                        }

                    }else
                    {
                        this.sanitationStatus = 'Sanitation done.';
                        this.rowCountField =  false;
                        this.sanitationBtn = false;
                    }
                }
            })
            .catch((error) =>
            {
                console.log(error);
            })
        },
        sanitationProcess: function()
        {
            this.rowCountField = true;
            this.sanitationBtn = true;
            this.sanitationStatus = 'Connecting to server...'

            axios.get(`sanitation/start-process`)
            .then((response) =>
            {
                this.sanitationStatus = 'Sanitation in process...';

                localStorage.startTime = new Date().getTime();
                this.startTime = localStorage.startTime;

                this.runTime = '00h 00m 00s';

                setInterval(() => {
                    if(this.totalRun < 4)
                    {
                        this.initialData(true);
                    }else {
                        this.initialData(false);
                    }
                }, 10000);
            })
            .catch((error) =>
            {
                console.log(error);
                this.sanitationProcess();
            })
        },
        convertToString:function(millis)
        {
            /*
                https://gist.github.com/robertpataki/d0b40a1cbbb71764dd94e16cbc99d42f
             */
            let delim = " ";
            let hours = Math.floor(millis / (1000 * 60 * 60) % 60);
            let minutes = Math.floor(millis / (1000 * 60) % 60);
            let seconds = Math.floor(millis / 1000 % 60);
            hours = hours < 10 ? '0' + hours : hours;
            minutes = minutes < 10 ? '0' + minutes : minutes;
            seconds = seconds < 10 ? '0' + seconds : seconds;
            return hours + 'h'+ delim + minutes + 'm' + delim + seconds + 's';
        },
        getUrlParameter:function (name)
        {
            /*
                https://davidwalsh.name/query-string-javascript
             */
            name = name.replace(/[\[]/, '\\[').replace(/[\]]/, '\\]');
            var regex = new RegExp('[\\?&]' + name + '=([^&#]*)');
            var results = regex.exec(location.search);
            return results === null ? '' : decodeURIComponent(results[1].replace(/\+/g, ' '));
        }
    }
});