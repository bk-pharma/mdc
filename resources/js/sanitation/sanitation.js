new Vue({
    el: '#sanitation-container',
    data() {
        return {
           sanitationStatus : '',
           sanitationBtn: false,
           totalRun: 0,
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
           percentageSanitationProcess: 0
        }
    },
      mounted() {

        if (localStorage.startTime)
        {
          this.startTime = localStorage.startTime;
        }else
        {
            this.startTime = '';
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
    created()
    {
        if(parseInt(this.getUrlParameter('running')) === 1)
        {
            this.sanitationStatus = 'Sanitation in process...';
            this.endTime = new Date().getTime();

            this.runTime = this.convertToString(this.endTime - localStorage.startTime);

            setInterval(() => {
                this.initialData(true);
            }, 20000);
        }else
        {
            this.initialData(false);
        }
    },
    methods : {
        initialData:function(isSanitationRunning)
        {
            axios.get(`sanitation/sanitized-total`)
            .then((response) =>
            {
                let resp = response.data;
                this.rowCount = parseInt(resp.totalRaw - resp.totalSanitized);
                this.totalSanitizedRow = resp.totalSanitized;
                this.totalSanitizedAmount = resp.totalAmount;
                this.totalUnsanitizedRow = (resp.totalRaw - resp.totalSanitized);

                this.percentageSanitizedRow = (resp.totalSanitized / resp.totalRaw) * 100;

                if(isSanitationRunning)
                {
                    if(resp.sanitationProcess > 0)
                    {
                        this.rowCountField = true;
                        this.sanitationBtn = true;
                        this.sanitationStatus = 'Sanitation in process...';
                        localStorage.endTime = new Date().getTime();
                        this.endTime = localStorage.endTime;
                    }else
                    {
                        this.rowCountField = false;
                        this.sanitationBtn = false;
                        this.sanitationStatus = 'Sanitation done.';
                        this.endTime = localStorage.endTime;
                    }

                    this.runTime = this.convertToString(this.endTime - this.startTime);
                }else
                {
                    this.sanitationStatus = '';
                    this.runTime = '';
                }
            })
            .catch((error) =>
            {
                console.log(error);
            })
        },
        startConsole: function()
        {
            this.sanitationStatus = 'Connecting to server...';
            this.runTime = '';

            let processNeeded = Math.round(this.rowCount / 10);

            for(let i = 0; i < 10; i++)
            {
                this.sanitationProcess(processNeeded * i, processNeeded);
            }

            // this.sanitationProcess(0, 100000);
            // this.sanitationProcess(100001, 100000);
            // this.sanitationProcess(200001, 100000);
            // this.sanitationProcess(300001, 100000);
            // this.sanitationProcess(400001, 100000);
            // this.sanitationProcess(500001, 100000);
            // this.sanitationProcess(600001, 100000);
            // this.sanitationProcess(700001, 100000);
            // this.sanitationProcess(800001, 100000);
            // this.sanitationProcess(900001, 100000);

            localStorage.startTime = new Date().getTime();
            this.endTime = new Date().getTime();

            this.runTime = this.convertToString(this.endTime - localStorage.startTime);

            setTimeout(() => {
                location.replace(`${window.location.href}?running=1`);
            },100000);
        },
        sanitationProcess: function(rowStart, rowCount)
        {
            this.rowCountField = true;
            this.sanitationBtn = true;

            let data = {
                rowStart: rowStart,
                rowCount: rowCount
            };

            axios.get(`sanitation/start-process/${rowStart}/${rowCount}`)
            .then((response) =>
            {
                let resp = response.data;

                this.totalRaw = resp.totalRaw;
                this.totalSanitizedRow = resp.totalSanitized;
                this.percentageSanitizedRow = (resp.totalSanitized / resp.totalRaw) * 100;
                this.totalSanitizedAmount = resp.totalAmount;
                this.totalUnsanitizedRow = (parseInt(resp.totalRaw) - parseInt(resp.totalSanitized));
            })
            .catch((error) =>
            {
                console.log(error);
                this.sanitationProcess(rowStart, rowCount);
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