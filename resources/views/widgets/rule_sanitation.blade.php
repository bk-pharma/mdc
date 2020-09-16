<style>
.links{
    float: right;
}
.text-dark{
    font-size: 18px;
    color: #000;
}
</style>
<div class="col-md-8" style="border: 2px solid #000; background-color: #fff;margin-top: 10px; margin-bottom: 10px; padding: 20px 20px 20px 20px !important;">
    <h4>Sanitize Selected Row(s)</h4>
    <div class="col-md-12">
        <span style="float: right;">
            <input type="checkbox" name="apply_all_rule" id="apply_all_rule" value="1"> Apply this rule to all rows
        </span>
    </div>
    <div class="col-md-12">
        <div class="row" style="margin-top: 20px;">
            <div class="col-md-4">
                <fieldset style="border: 1px solid #000;">
                    <legend style="font-size: 15px;">Assign to MD</legend>
                    <input type="text" class="form-control" name="assign_to_md" placeholder="Assign to md" list="doctors">
                    <datalist id="doctors">
                        @foreach($doctors as $doctor)
                          <option value="{{ $doctor->sanit_mdcode}}">
                          	  {{-- <option value="{{ $doctor->sanit_mdcode.' | '.$doctor->sanit_mdname }}"> --}}
                          	{{$doctor->sanit_mdname }} - {{ $doctor->sanit_group }}
                          </option>

                        @endforeach
                    </datalist>
                    <br/>
                    <span style="padding: 5px;">
                        <input type="checkbox" name="unidentified" value="1"> unidentified
                    </span>
                </fieldset>
            </div>
            <div class="col-md-8">
                @foreach($toSanitizes as $key => $toSanitize)
                    <fieldset style="border: 1px solid #000;"  id="page{{ $key += 1 }}" data-page="{{ $key }}" class="text-bold">
                        <legend style="font-size: 15px;">Set Rule</legend>
                        <p style="padding-top: 5px; padding-left: 20px;" class="text-bold"> ID: {{ $toSanitize->raw_id }}</p>
                        <input type="hidden" name="rule_raw_id[]" value="{{ $toSanitize->raw_id }}">
                        <input type="hidden" name="rule_raw_md_code[]" value="{{ $toSanitize->raw_id }}">
                        <div class="col-md-4">
                            <span style="padding: 5px;" class="text-bold">
                                <input type="checkbox" name="rule_md_name[]" value="{{ $toSanitize->raw_doctor }}" class="rule_md_name{{ $key }}"> 1 - Raw MD Name: {{ $toSanitize->raw_doctor }}
                            </span>
                            <br/><br/>
                            <span style="padding: 5px;" class="text-bold">
                                <input type="checkbox" name="rule_license_number[]" value="{{ $toSanitize->raw_license }}" class="rule_license_number"> 2 - License Number: {{ $toSanitize->raw_license }}
                            </span>
                        </div>
                        <div class="col-md-4">
                            <span style="padding: 5px;" class="text-bold">
                                <input type="checkbox" name="rule_location[]" value="{{ $toSanitize->raw_address }}" class="rule_location"> 3 - Location: {{ $toSanitize->raw_address }}
                            </span>
                            <br/><br/>
                            <span style="padding: 5px;" class="text-bold">
                                <input type="checkbox" name="rule_branch_name[]" value="{{ $toSanitize->raw_branchname }}" class="rule_branch_name"> 4 - Branch Name: {{ $toSanitize->raw_branchname }}
                            </span>
                        </div>
                        <div class="col-md-3">
                            <span style="padding: 5px;" class="text-bold">
                                <input type="checkbox" name="rule_lba_code[]" value="{{ $toSanitize->raw_lbucode }}" class="rule_lba_code"> 5 - LBA Code: {{ $toSanitize->raw_lbucode }}
                            </span>
                        </div>
                    </fieldset>
                @endforeach
                <br/>
                <div class="links text-bold float-right">
                    <a href="#" class="text-dark prev" onclick="previousPage('{{ count($toSanitizes) }}')"><< prev</a>
                        <span class="text-dark"> <span id="current_page"></span> / {{ count($toSanitizes) }} </span>
                    <!-- @for($i = 1; $i <= count($toSanitizes); $i++)

                            <a href="#" class="text-dark page-{{ $i }}" onclick="showPages('{{ $i }}', '{{ count($toSanitizes) }}')">{{ $i }}</a>

                    @endfor -->
                    <a href="#" class="text-dark next" onclick="nextPage('{{ count($toSanitizes) }}')"> next >></a>
                </div>
                <button class="btn btn-primary" onclick="submitSanitize('{{ count($toSanitizes) }}')">Submit</button>
            </div>
        </div>
    </div>
</div>

<script>
$(document).ready(function() {

    var numPage = '{{ count($toSanitizes) }}';

    showPages(1, numPage)


});


function showPages(id, total){

var totalNumberOfPages = total;
for(var i=1; i<=totalNumberOfPages; i++){

    if (document.getElementById('page'+i)) {

        document.getElementById('page'+i).style.display='none';

        $('#page'+i).removeClass(' active');

        $('.page-'+i).removeAttr("style");
    }

}
    if (document.getElementById('page'+id)) {

        document.getElementById('page'+id).style.display='block';

        $('#page'+id).addClass(' active');

        $('.page-'+id).css({
            'background-color': '#000',
            'color': '#fff'
        });
        var currentPage = $('.active').data('page');

        if(currentPage == 1){
            $('.prev').hide();
        }else{
            $('.prev').show();
        }

        if(currentPage == total){
            $('.next').hide();
        }else{
            $('.next').show();
        }

        $('#current_page').text(currentPage);
    }
};

function previousPage(total) {

    var currentPage = $('.active').data('page');

    if(currentPage == 1){
        $('.prev').hide();
    }else{
        $('.prev').show();
    }

    if(currentPage == total){
        $('.next').hide();
    }else{
        $('.next').show();
    }

    var previous = currentPage - 1;

    $('#current_page').text(previous);

    showPages(previous, total);
}

function nextPage(total){

    var currentPage = $('.active').data('page');

    if(currentPage == 1){
        $('.prev').hide();
    }else{
        $('.prev').show();
    }

    if(currentPage == total){
        $('.next').hide();
    }else{
        $('.next').show();
    }

    var next = currentPage + 1;

    $('#current_page').text(next);

    showPages(next, total);

}

function updateByMdCode(rule_raw_id, mdCode, ruleCode){

    var formData = new FormData();
        formData.append('_token', '{{ csrf_token() }}');
        formData.append('mdCode', mdCode);
        formData.append('rule_raw_id', rule_raw_id);
        formData.append('ruleCode', ruleCode);
    
    $.ajax({
        url: '{{ route("set.rules_by") }}',
        type: 'POST',
        data: formData,
        contentType: false,
        processData: false,
        success:function(response){

            console.log(response);
        },
        error: function (response) {
            console.log(response);
        }
    });
}

function submitSanitize(total){

    var apply_all_rule = $('#apply_all_rule').is(":checked");

    var rule_raw_md_code = $('input[name="assign_to_md"]').val();

    if(rule_raw_md_code === null || rule_raw_md_code === ""){

        iziToast.warning({
            title: 'Warning',
            message: 'Chosse MD Code',
            position: 'topRight',
        });
        
    }else{

        var rule_raw_id = $('input[name="rule_raw_id[]"]').map(function () {
                return this.value;
            }).get();

        if(apply_all_rule){

            if($('input[name="rule_md_name[]"]').is(":checked")){

                var rule_md_name = $('input[name="rule_md_name[]"]:checkbox').map(function () {
                    return this.checked ? this.value : this.value;
                }).get();

            }else{

                var rule_md_name = [];
                for(var i = 1; i <= $('input[name="rule_md_name[]"]').length; i++){
                    rule_md_name.push("");
                }
            }

            if($('input[name="rule_license_number[]"]').is(":checked")){

                var rule_license_number = $('input[name="rule_license_number[]"]:checkbox').map(function () {
                    return this.checked ? this.value : this.value;
                }).get();

            }else{

                var rule_license_number = [];
                for(var i = 1; i <= $('input[name="rule_license_number[]"]').length; i++){
                    rule_license_number.push("");
                }
            }

            if($('input[name="rule_location[]"]').is(":checked")){

                var rule_location = $('input[name="rule_location[]"]:checkbox').map(function () {
                    return this.checked ? this.value : this.value;
                }).get();

            }else{

                var rule_location = [];
                for(var i = 1; i <= $('input[name="rule_location[]"]').length; i++){
                    rule_location.push("");
                }
            }

            if($('input[name="rule_branch_name[]"]').is(":checked")){

                var rule_branch_name = $('input[name="rule_branch_name[]"]:checkbox').map(function () {
                    return this.checked ? this.value : this.value;
                }).get();

            }else{

                var rule_branch_name = [];
                for(var i = 1; i <= $('input[name="rule_branch_name[]"]').length; i++){
                    rule_branch_name.push("");
                }
            }

            if($('input[name="rule_lba_code[]"]').is(":checked")){

                var rule_lba_code = $('input[name="rule_lba_code[]"]:checkbox').map(function () {
                    return this.checked ? this.value : this.value;
                }).get();

            }else{

                var rule_lba_code = [];
                for(var i = 1; i <= $('input[name="rule_lba_code[]"]').length; i++){
                    rule_lba_code.push("");
                }
            }


        }else{

            var rule_md_name = $('input[name="rule_md_name[]"]:checkbox').map(function () {
                return this.checked ? this.value : "";
            }).get();

            var rule_license_number = $('input[name="rule_license_number[]"]:checkbox').map(function () {
                return this.checked ? this.value : "";
            }).get();

            var rule_location = $('input[name="rule_location[]"]:checkbox').map(function () {
                return this.checked ? this.value : "";
            }).get();

            var rule_branch_name = $('input[name="rule_branch_name[]"]:checkbox').map(function () {
                return this.checked ? this.value : "";
            }).get();

            var rule_lba_code = $('input[name="rule_lba_code[]"]:checkbox').map(function () {
                return this.checked ? this.value : "";
            }).get();

        }

        var formData = new FormData();
            formData.append('_token', '{{ csrf_token() }}');
            formData.append('mdCode', rule_raw_md_code);
            formData.append('rawId', rule_raw_id);
            formData.append('rawDoctor', rule_md_name);
            formData.append('rawLicense', rule_license_number);
            formData.append('rule_location', rule_location);
            formData.append('rule_branch_name', rule_branch_name);
            formData.append('rule_lba_code', rule_lba_code);
          
        $.ajax({
            url: '{{ route("rules.sanitaion") }}',
            type: 'POST',
            data: formData,
            contentType: false,
            processData: false,
            success:function(response){

                // console.log(rule_raw_id);
                let mdCode = response.mdCode;
                let ruleCode = response.rules.ruleCode;

                // /* console.log(mdCode);
                // console.log(ruleCode); */
                updateByMdCode(rule_raw_id, mdCode, ruleCode);
                 iziToast.success({
                         title: 'Success',
                         message: 'Rules has been added!',
                         position: 'topRight',
                     });
            },
            error: function (response) {
                console.log(response);
            }
        });
    }
}
</script>