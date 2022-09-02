<div class="companydes">
    <?php $company = \App\Models\Company::where('id', 1)->first(); ?>
    <h1 align="center">{{ $company->name }} </h1>
    <p align="center">{{ $company->address }},{{ $company->CityName->name }},{{ $company->StateName->name }},{{ $company->CountryName->name }}</p>
    <p align="center"><b>Mobile:</b>{{ $company->mobile_no}} </p>
    <p align="center"><b>Phone:</b>{{ $company->tell_no}}</p>
    <p align="center"><b>Email:</b>{{ $company->companyemail}}</p>
    <p align="center"><b>Website:</b>{{ $company->website}}</p>
</div>