new Vue({
    el: '#automatedPhases-container',
    data() {
        return {
           sanitationIterator: 6, // nextIndex = array[index + 6]
           automatedLabel : '',
           sanitationBtn: false,
           processRowStartArr: [],
           rowCount: 0,
           rowCountField: false,
           totalSanitizedRow: 0,
           percentageSanitizedRow: 0,
           totalUnsanitizedRow: 0,
           totalSanitizedAmount: 0,
           totalRaw: 0,
           rowsPerSanitationProcess: 100,
           currentSanitationProcess: 0,
           totalSanitationProcess:  0,
           percentageSanitationProcess: 0
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
        this.initialData();
    },
    updated()
    {
        if(this.currentSanitationProcess === this.totalSanitationProcess)
        {
            this.automatedLabel = '';
            this.sanitationBtn = false;
            this.rowCountField = false;
        }
    },
    methods : {
        startConsole: function()
        {
            this.automatedLabel = 'Sanitation in process...';

            let sanitationProcessNeeded = (this.rowCount / this.rowsPerSanitationProcess);
            let processRowStart = 0;

            for(let i = 0; i < sanitationProcessNeeded; i++)
            {
                if(i === 0)
                {
                    processRowStart = 0;
                }else
                {
                    processRowStart = (i * this.rowsPerSanitationProcess) + 1;
                }

                this.processRowStartArr.push(processRowStart);
            }

            this.totalSanitationProcess = sanitationProcessNeeded;

            this.sanitationProcess1(0);
            this.sanitationProcess2(1);
            this.sanitationProcess3(2);
            this.sanitationProcess4(3);
            this.sanitationProcess5(4);
            this.sanitationProcess6(5);
        },
        sanitationProcess1: function(index)
        {
            this.rowCountField = true;
            this.sanitationBtn = true;

            this.currentSanitationProcess += 1;

            let rowStart = this.processRowStartArr[index];

            axios.get(`automated/start-process/${rowStart}/${this.rowsPerSanitationProcess}`)
            .then((response) =>
            {
                let resp = response.data;

                let nextIndex = index + this.sanitationIterator;

                if(typeof this.processRowStartArr[nextIndex] !== 'undefined')
                {
                    this.sanitationProcess1(nextIndex);
                }

                this.totalRaw = resp.totalRaw;
                this.totalSanitizedRow = resp.totalSanitized;
                this.totalSanitizedAmount = resp.totalAmount;
                this.totalUnsanitizedRow = (parseInt(resp.totalRaw) - parseInt(resp.totalSanitized));

                this.percentageSanitizedRow = (resp.totalSanitized / resp.totalRaw) * 100;
                this.percentageSanitationProcess = (this.currentSanitationProcess / this.totalSanitationProcess) * 100;
            })
            .catch((error) =>
            {
                console.log(error);
            })
        },
        sanitationProcess2: function(index)
        {
            this.rowCountField = true;
            this.sanitationBtn = true;

            this.currentSanitationProcess += 1;

            let rowStart = this.processRowStartArr[index];

            axios.get(`automated/start-process/${rowStart}/${this.rowsPerSanitationProcess}`)
            .then((response) =>
            {
                let resp = response.data;

                let nextIndex = index + this.sanitationIterator;

                if(typeof this.processRowStartArr[nextIndex] !== 'undefined')
                {
                    this.sanitationProcess2(nextIndex);
                }

                this.totalRaw = resp.totalRaw;
                this.totalSanitizedRow = resp.totalSanitized;
                this.totalSanitizedAmount = resp.totalAmount;
                this.totalUnsanitizedRow = (parseInt(resp.totalRaw) - parseInt(resp.totalSanitized));

                this.percentageSanitizedRow = (resp.totalSanitized / resp.totalRaw) * 100;
                this.percentageSanitationProcess = (this.currentSanitationProcess / this.totalSanitationProcess) * 100;
            })
            .catch((error) =>
            {
                console.log(error);
            })
        },
        sanitationProcess3: function(index)
        {
            this.rowCountField = true;
            this.sanitationBtn = true;

            this.currentSanitationProcess += 1;

            let rowStart = this.processRowStartArr[index];

            axios.get(`automated/start-process/${rowStart}/${this.rowsPerSanitationProcess}`)
            .then((response) =>
            {
                let resp = response.data;

                let nextIndex = index + this.sanitationIterator;

                if(typeof this.processRowStartArr[nextIndex] !== 'undefined')
                {
                    this.sanitationProcess3(nextIndex);
                }

                this.totalRaw = resp.totalRaw;
                this.totalSanitizedRow = resp.totalSanitized;
                this.totalSanitizedAmount = resp.totalAmount;
                this.totalUnsanitizedRow = (parseInt(resp.totalRaw) - parseInt(resp.totalSanitized));

                this.percentageSanitizedRow = (resp.totalSanitized / resp.totalRaw) * 100;
                this.percentageSanitationProcess = (this.currentSanitationProcess / this.totalSanitationProcess) * 100;
            })
            .catch((error) =>
            {
                console.log(error);
            })
        },
        sanitationProcess4: function(index)
        {
            this.rowCountField = true;
            this.sanitationBtn = true;

            this.currentSanitationProcess += 1;

            let rowStart = this.processRowStartArr[index];

            axios.get(`automated/start-process/${rowStart}/${this.rowsPerSanitationProcess}`)
            .then((response) =>
            {
                let resp = response.data;

                let nextIndex = index + this.sanitationIterator;

                if(typeof this.processRowStartArr[nextIndex] !== 'undefined')
                {
                    this.sanitationProcess4(nextIndex);
                }

                this.totalRaw = resp.totalRaw;
                this.totalSanitizedRow = resp.totalSanitized;
                this.totalSanitizedAmount = resp.totalAmount;
                this.totalUnsanitizedRow = (parseInt(resp.totalRaw) - parseInt(resp.totalSanitized));

                this.percentageSanitizedRow = (resp.totalSanitized / resp.totalRaw) * 100;
                this.percentageSanitationProcess = (this.currentSanitationProcess / this.totalSanitationProcess) * 100;
            })
            .catch((error) =>
            {
                console.log(error);
            })
        },
        sanitationProcess5: function(index)
        {
            this.rowCountField = true;
            this.sanitationBtn = true;

            this.currentSanitationProcess += 1;

            let rowStart = this.processRowStartArr[index];

            axios.get(`automated/start-process/${rowStart}/${this.rowsPerSanitationProcess}`)
            .then((response) =>
            {
                let resp = response.data;

                let nextIndex = index + this.sanitationIterator;

                if(typeof this.processRowStartArr[nextIndex] !== 'undefined')
                {
                    this.sanitationProcess5(nextIndex);
                }

                this.totalRaw = resp.totalRaw;
                this.totalSanitizedRow = resp.totalSanitized;
                this.totalSanitizedAmount = resp.totalAmount;
                this.totalUnsanitizedRow = (parseInt(resp.totalRaw) - parseInt(resp.totalSanitized));

                this.percentageSanitizedRow = (resp.totalSanitized / resp.totalRaw) * 100;
                this.percentageSanitationProcess = (this.currentSanitationProcess / this.totalSanitationProcess) * 100;
            })
            .catch((error) =>
            {
                console.log(error);
            })
        },
        sanitationProcess6: function(index)
        {
            this.rowCountField = true;
            this.sanitationBtn = true;

            this.currentSanitationProcess += 1;

            let rowStart = this.processRowStartArr[index];

            axios.get(`automated/start-process/${rowStart}/${this.rowsPerSanitationProcess}`)
            .then((response) =>
            {
                let resp = response.data;

                let nextIndex = index + this.sanitationIterator;

                if(typeof this.processRowStartArr[nextIndex] !== 'undefined')
                {
                    this.sanitationProcess6(nextIndex);
                }

                this.totalRaw = resp.totalRaw;
                this.totalSanitizedRow = resp.totalSanitized;
                this.totalSanitizedAmount = resp.totalAmount;
                this.totalUnsanitizedRow = (parseInt(resp.totalRaw) - parseInt(resp.totalSanitized));

                this.percentageSanitizedRow = (resp.totalSanitized / resp.totalRaw) * 100;
                this.percentageSanitationProcess = (this.currentSanitationProcess / this.totalSanitationProcess) * 100;
            })
            .catch((error) =>
            {
                console.log(error);
            })
        },
        initialData:function()
        {
            axios.get(`automated/sanitized-total`)
            .then((response) =>
            {
                let resp = response.data;
                this.rowCount = (resp.totalRaw - resp.totalSanitized);
                this.totalSanitizedRow = resp.totalSanitized;
                this.totalSanitizedAmount = resp.totalAmount;
                this.totalUnsanitizedRow = (resp.totalRaw - resp.totalSanitized);
            })
            .catch((error) =>
            {
                console.log(error);
            })
        }
    }
});