<div class="container">
    <div class="row">
        <div class="col-sm">
            <h6>Report generator</h6>
            <form action=" <?php realpath('/index.php')?>" method="post" >
                <div class="mb-3 row">
                    <label for="start_date" class="col-sm-4 col-form-label">Start date</label>
                    <div class="col-sm-8">
                        <input name="startDate" dataformatas="Y-m-d" value="2018-05-01" id="start_date" type="date">
                    </div>
                </div>
                <div class="mb-3 row">
                    <label for="end_date" class="col-sm-4 col-form-label">End date</label>
                    <div class="col-sm-8">
                        <input name="endDate" value="2018-05-07" id="end_date" type="date">
                    </div>
                </div>
                <div class="mb-3 row">
                    <label for="report_type" class="col-sm-4 col-form-label">Select Report Type</label>
                    <div class="col-sm-8">
                        <select name="report_type" id="report_type">
                            <option selected value="null">Select a report</option>
                            <option value="dailyTurnover">Daily Turnover</option>
                            <option value="dailyTurnoverByBrand">Daily Turnover by brand</option>
                        </select>
                    </div>
                </div>
                <div class="mb-3">
                    <input type="submit"  value="Generate and download report " />
                </div>
            </form>
        </div>
    </div>
</div>
