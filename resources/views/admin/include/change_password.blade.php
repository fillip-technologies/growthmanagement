@extends('admin.include.layout')

@section('heading', 'Change Password')
@section('title', 'Password Change')

@section('content')
<div class="content-wrapper min-h-screen bg-gradient-to-b from-gray-50 to-gray-100 py-12">
  <div class="container mx-auto px-4 max-w-2xl">
    <div class="bg-white shadow-2xl rounded-2xl overflow-hidden">
      <div class="p-6 md:p-8 lg:p-10">
        <div class="flex items-center justify-between mb-6">
          <h2 class="text-2xl md:text-3xl font-semibold text-gray-800">Change Password</h2>
          <div class="text-sm text-gray-500">Security level: <span id="uiSecurityLevel" class="font-semibold">—</span></div>
        </div>

        @if(session('status'))
          <div class="mb-4 p-3 rounded-md bg-green-50 border border-green-100 text-green-700">
            {{ session('status') }}
          </div>
        @endif

        @if($errors->any())
          <div class="mb-4 p-3 rounded-md bg-red-50 border border-red-100 text-red-700">
            <ul class="list-disc list-inside space-y-1">
              @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
              @endforeach
            </ul>
          </div>
        @endif

        <form method="POST" action="{{ route('password.updated') }}" class="space-y-6">
          @csrf

          <div class="space-y-2">
            <label for="current_password" class="block text-sm font-medium text-gray-700">Current Password</label>
            <div class="relative">
              <input id="current_password" type="password" name="current_password" required autofocus
                     class="w-full border border-gray-200 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-indigo-300 focus:border-indigo-500" />
              <button type="button" onclick="togglePassword('current_password', this)" class="absolute right-2 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-700" aria-label="Toggle current password visibility">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
              </button>
            </div>
          </div>

          <div class="space-y-2">
            <label for="password" class="block text-sm font-medium text-gray-700">New Password</label>
            <div class="relative">
              <input id="password" type="password" name="password" required oninput="updateStrength(this.value)"
                     class="w-full border border-gray-200 rounded-lg px-4 py-3 pr-12 focus:outline-none focus:ring-2 focus:ring-indigo-300 focus:border-indigo-500" />

              <button type="button" onclick="togglePassword('password', this)" class="absolute right-2 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-700" aria-label="Toggle new password visibility">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
              </button>
            </div>

            <div class="mt-3">
              <div class="w-full bg-gray-100 rounded-full h-2 overflow-hidden">
                <div id="strengthBar" class="h-2 rounded-full" style="width:0%"></div>
              </div>
              <div id="strengthMessage" class="mt-2 text-sm font-medium text-gray-600"></div>
            </div>

            <ul class="mt-3 text-sm text-gray-500 space-y-1">
              <li id="rule-length">• At least 8 characters</li>
              <li id="rule-case">• Uppercase and lowercase letters</li>
              <li id="rule-number">• At least one number</li>
              <li id="rule-special">• At least one special character (e.g. !@#$%)</li>
            </ul>
          </div>

          <div class="space-y-2">
            <label for="password_confirmation" class="block text-sm font-medium text-gray-700">Confirm New Password</label>
            <div class="relative">
              <input id="password_confirmation" type="password" name="password_confirmation" required
                     class="w-full border border-gray-200 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-indigo-300 focus:border-indigo-500" />
              <button type="button" onclick="togglePassword('password_confirmation', this)" class="absolute right-2 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-700" aria-label="Toggle confirm password visibility">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
              </button>
            </div>
          </div>

          <div class="pt-4 border-t border-gray-100 flex items-center justify-between">
            <div class="text-sm text-gray-600">Tip: Use a passphrase of 3+ random words for better memorability.</div>
            <div>
              <button type="submit" class="inline-flex items-center gap-2 px-5 py-2 bg-red-800 text-white rounded-lg shadow hover:bg-red-600 focus:outline-none focus:ring-2 focus:ring-indigo-400">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 11c0 3-3 6-9 6"/></svg>
                Change Password
              </button>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

<script>
function setElementState(id, satisfied) {
  const el = document.getElementById(id);
  if (!el) return;
  if (satisfied) {
    el.classList.add('text-green-600');
    el.classList.remove('text-gray-500');
  } else {
    el.classList.remove('text-green-600');
    el.classList.add('text-gray-500');
  }
}

function updateStrength(password) {
  const bar = document.getElementById('strengthBar');
  const msg = document.getElementById('strengthMessage');
  let score = 0;

  const lengthOK = password.length >= 8;
  const caseOK = /[a-z]/.test(password) && /[A-Z]/.test(password);
  const numberOK = /[0-9]/.test(password);
  const specialOK = /[^A-Za-z0-9]/.test(password);

  if (lengthOK) score += 1;
  if (caseOK) score += 1;
  if (numberOK) score += 1;
  if (specialOK) score += 1;

  // update rules visually
  setElementState('rule-length', lengthOK);
  setElementState('rule-case', caseOK);
  setElementState('rule-number', numberOK);
  setElementState('rule-special', specialOK);

  // progress
  const pct = (score / 4) * 100;
  bar.style.width = pct + '%';

  // color logic without forcing Tailwind classes directly (fallback inline)
  bar.style.backgroundColor = score <= 1 ? '#ef4444' : (score === 2 ? '#f59e0b' : '#10b981');

  if (score === 0) {
    msg.textContent = '';
    document.getElementById('uiSecurityLevel').textContent = '—';
  } else if (score <= 1) {
    msg.textContent = 'Weak';
    document.getElementById('uiSecurityLevel').textContent = 'Low';
  } else if (score === 2) {
    msg.textContent = 'Medium';
    document.getElementById('uiSecurityLevel').textContent = 'Medium';
  } else {
    msg.textContent = 'Strong';
    document.getElementById('uiSecurityLevel').textContent = 'High';
  }
}

function togglePassword(inputId, btn) {
  const input = document.getElementById(inputId);
  if (!input) return;
  if (input.type === 'password') {
    input.type = 'text';
    btn.classList.add('text-indigo-600');
  } else {
    input.type = 'password';
    btn.classList.remove('text-indigo-600');
  }
}
</script>
@endsection

