new Vue({
    el: '#automatedPhases-container',
    data() {
        return {
           sanitationIterator: 20, // nextIndex = array[index + 10]
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
           rowsPerSanitationProcess: 50,
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
            this.sanitationProcess1(1);
            this.sanitationProcess1(2);
            this.sanitationProcess1(3);
            this.sanitationProcess1(4);
            this.sanitationProcess1(5);
            this.sanitationProcess1(6);
            this.sanitationProcess1(7);
            this.sanitationProcess1(8);
            this.sanitationProcess1(9);
            this.sanitationProcess1(10);
            this.sanitationProcess1(11);
            this.sanitationProcess1(12);
            this.sanitationProcess1(13);
            this.sanitationProcess1(14);
            this.sanitationProcess1(15);
            this.sanitationProcess1(16);
            this.sanitationProcess1(17);
            this.sanitationProcess1(18);
            this.sanitationProcess1(19);

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
        sanitationProcess7: function(index)
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
                    this.sanitationProcess7(nextIndex);
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
        sanitationProcess8: function(index)
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
                    this.sanitationProcess8(nextIndex);
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
        sanitationProcess9: function(index)
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
                    this.sanitationProcess9(nextIndex);
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
        sanitationProcess10: function(index)
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
                    this.sanitationProcess10(nextIndex);
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
        sanitationProcess11: function(index)
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
                    this.sanitationProcess11(nextIndex);
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
        sanitationProcess12: function(index)
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
                    this.sanitationProcess12(nextIndex);
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
        sanitationProcess13: function(index)
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
                    this.sanitationProcess13(nextIndex);
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
        sanitationProcess14: function(index)
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
                    this.sanitationProcess14(nextIndex);
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
        sanitationProcess15: function(index)
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
                    this.sanitationProcess15(nextIndex);
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
        sanitationProcess16: function(index)
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
                    this.sanitationProcess16(nextIndex);
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
        sanitationProcess17: function(index)
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
                    this.sanitationProcess17(nextIndex);
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
        sanitationProcess18: function(index)
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
                    this.sanitationProcess18(nextIndex);
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
        sanitationProcess19: function(index)
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
                    this.sanitationProcess19(nextIndex);
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
        sanitationProcess20: function(index)
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
                    this.sanitationProcess20(nextIndex);
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
                this.totalUnsanitizedRow = (resp.totalRaw - resp.totalSanitized);
            })
            .catch((error) =>
            {
                console.log(error);
            })
        }
    }
});