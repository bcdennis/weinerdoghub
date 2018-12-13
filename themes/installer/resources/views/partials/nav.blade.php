<ul class="steps">
    <li {!! setStepActive('requirements') !!}>
        <a href="{{ route('requirements') }}">1. Requirements</a>
    </li>
    <li {!! setStepActive('database') !!}>
        <a href="{{ route('database') }}">2. Database</a>
    </li>
    <li {!! setStepActive('email') !!}>
        <a href="{{ route('email') }}">3. Email</a>
    </li>
    <li {!! setStepActive('admin') !!}>
        <a href="{{ route('admin') }}">4. User</a>
    </li>
    <li {!! setStepActive('finish') !!}>
        <a href="{{ route('finish') }}">5. Finish</a>
    </li>
</ul>