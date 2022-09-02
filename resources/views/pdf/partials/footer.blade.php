<?php $company = \App\Models\Company::where('id', 1)->first(); ?>
<footer>
    <p align="center"><b>Mobile:</b>{{ $company->mobile_no}}
        <b>Phone:</b>{{ $company->tell_no}}
        <b>Email:</b>{{ $company->companyemail}}
        <b>Website:</b>{{ $company->website}}</p>
</footer>