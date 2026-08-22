    <section id="apply" class="section career-apply-section">
        <div class="site-container career-apply-grid">
            <aside class="reveal-on-scroll"><span class="eyebrow eyebrow-light">Application</span><h2>Tell us about you.</h2><p>Fields marked required are needed to review and respond to your application.</p><ul><li><i data-lucide="file-check"></i>PDF, DOC or DOCX resume</li><li><i data-lucide="hard-drive"></i>Maximum file size: 5 MB</li></ul></aside>
            <div class="career-form-card reveal-on-scroll" data-reveal-delay="100">
                @if (session('success'))<div class="career-success" role="status"><i data-lucide="check-circle"></i><h2>Application received.</h2><p>{{ session('success') }}</p></div>@else
                    @if ($errors->any())<div class="form-error-summary" role="alert"><strong>Please check the application details.</strong><ul>@foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul></div>@endif
                    <form action="{{ route('career.apply') }}" method="POST" enctype="multipart/form-data" class="career-form">@csrf
                        <div class="form-grid-two">
                            <label class="form-field" for="firstName"><span>First name <em>Required</em></span><input id="firstName" name="first_name" type="text" autocomplete="given-name" value="{{ old('first_name') }}" required maxlength="100"></label>
                            <label class="form-field" for="lastName"><span>Last name <em>Required</em></span><input id="lastName" name="last_name" type="text" autocomplete="family-name" value="{{ old('last_name') }}" required maxlength="100"></label>
                        </div>
                        <div class="form-grid-two">
                            <label class="form-field" for="careerEmail"><span>Email <em>Required</em></span><input id="careerEmail" name="email" type="email" autocomplete="email" value="{{ old('email') }}" required maxlength="255"></label>
                            <label class="form-field" for="careerPhone"><span>Phone <em>Required</em></span><input id="careerPhone" name="phone" type="tel" inputmode="tel" autocomplete="tel" value="{{ old('phone') }}" required maxlength="30"></label>
                        </div>
                        <label class="form-field" for="careerPosition"><span>Position <em>Required</em></span><select id="careerPosition" name="position" required><option value="">Choose a role</option>@foreach ($careers as $career)<option value="{{ $career->title }}" @selected(old('position') === $career->title)>{{ $career->title }} — {{ $career->location }}</option>@endforeach<option value="General expression of interest" @selected(old('position') === 'General expression of interest')>General expression of interest</option></select></label>
                        <div class="form-grid-two">
                            <label class="form-field" for="experience"><span>Relevant experience <em>Optional</em></span><select id="experience" name="experience"><option value="">Choose a range</option>@foreach (['0-1 years', '2-3 years', '4-5 years', '6-10 years', '10+ years'] as $experience)<option value="{{ $experience }}" @selected(old('experience') === $experience)>{{ $experience }}</option>@endforeach</select></label>
                            <label class="form-field" for="availability"><span>Availability <em>Optional</em></span><select id="availability" name="availability"><option value="">Choose availability</option>@foreach (['Immediate', '2 weeks notice', '1 month notice', 'Negotiable'] as $availability)<option value="{{ $availability }}" @selected(old('availability') === $availability)>{{ $availability }}</option>@endforeach</select></label>
                        </div>
                        <label class="form-field file-field" for="resume"><span>Resume / CV <em>Optional</em></span><input id="resume" name="resume" type="file" accept=".pdf,.doc,.docx"><small>Accepted: PDF, DOC, DOCX — maximum 5 MB.</small></label>
                        <label class="form-field" for="coverLetter"><span>Why would you like to work with Cleanway? <em>Optional</em></span><textarea id="coverLetter" name="cover_letter" rows="5" maxlength="3000">{{ old('cover_letter') }}</textarea></label>
                        <button class="button button-lime" type="submit">Submit application <i data-lucide="send"></i></button>
                    </form>
                @endif
            </div>
        </div>
    </section>
