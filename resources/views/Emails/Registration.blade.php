<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Welcome to Fillip Technologies</title>
  <style>
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }

    body {
      font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif;
      background-color: #f8fafc;
      margin: 0;
      padding: 24px 12px;
      display: flex;
      justify-content: center;
      align-items: center;
      min-height: 100vh;
    }

    .email-container {
      max-width: 600px;
      width: 100%;
      background-color: #ffffff;
      border-radius: 24px;
      overflow: hidden;
      box-shadow: 0 20px 60px -12px rgba(0, 0, 0, 0.15), 0 8px 24px -6px rgba(0, 0, 0, 0.05);
      transition: all 0.2s ease;
      border: 1px solid #f1f5f9;
    }

    /* -------- HEADER with gradient & modern touch -------- */
    .header {
      background: linear-gradient(135deg, #f97316 0%, #fb923c 50%, #facc15 100%);
      padding: 32px 24px 28px;
      text-align: center;
      position: relative;
    }

    .header::after {
      content: '';
      position: absolute;
      bottom: 0;
      left: 0;
      right: 0;
      height: 4px;
      background: rgba(255, 255, 255, 0.25);
      backdrop-filter: blur(2px);
    }

    .header-content {
      display: flex;
      flex-direction: column;
      align-items: center;
    }

    .brand-icon {
      display: inline-flex;
      align-items: center;
      justify-content: center;
      background: rgba(255, 255, 255, 0.2);
      backdrop-filter: blur(4px);
      padding: 12px 20px;
      border-radius: 60px;
      margin-bottom: 12px;
      border: 1px solid rgba(255, 255, 255, 0.3);
    }

    .brand-icon span {
      font-size: 22px;
      font-weight: 700;
      letter-spacing: -0.3px;
      color: #ffffff;
      text-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
    }

    .brand-icon .dot {
      display: inline-block;
      width: 8px;
      height: 8px;
      background: #ffffff;
      border-radius: 50%;
      margin: 0 6px;
      opacity: 0.7;
    }

    .header h1 {
      color: #ffffff;
      font-size: 28px;
      font-weight: 700;
      letter-spacing: -0.4px;
      margin: 4px 0 2px;
      text-shadow: 0 2px 12px rgba(0, 0, 0, 0.08);
    }

    .header .subhead {
      color: rgba(255, 255, 255, 0.9);
      font-size: 15px;
      font-weight: 400;
      letter-spacing: 0.2px;
      background: rgba(0, 0, 0, 0.08);
      padding: 4px 16px;
      border-radius: 30px;
      display: inline-block;
      backdrop-filter: blur(2px);
    }

    /* -------- CONTENT -------- */
    .content {
      padding: 36px 32px 28px;
      color: #0f172a;
      line-height: 1.6;
    }

    .greeting {
      margin-bottom: 8px;
    }

    .greeting h2 {
      font-size: 24px;
      font-weight: 600;
      color: #0f172a;
      letter-spacing: -0.3px;
      margin-bottom: 4px;
    }

    .greeting h2 span {
      color: #f97316;
    }

    .greeting p {
      color: #475569;
      font-size: 16px;
      margin-top: 4px;
    }

    .divider {
      height: 2px;
      background: linear-gradient(90deg, #f97316, #facc15, #f97316);
      opacity: 0.2;
      margin: 20px 0 24px;
      border-radius: 10px;
    }

    .message-box {
      background: #fefaf5;
      padding: 16px 20px;
      border-radius: 16px;
      border-left: 5px solid #f97316;
      margin-bottom: 24px;
    }

    .message-box p {
      margin: 0;
      color: #1e293b;
      font-size: 15px;
    }

    /* -------- CREDENTIALS CARD (modern) -------- */
    .credentials-card {
      background: #ffffff;
      border-radius: 20px;
      border: 1px solid #eef2f6;
      overflow: hidden;
      box-shadow: 0 4px 12px rgba(0, 0, 0, 0.02);
      margin: 20px 0 28px;
      transition: 0.2s;
    }

    .credential-item {
      display: flex;
      align-items: center;
      padding: 16px 20px;
      border-bottom: 1px solid #f1f5f9;
      transition: background 0.15s;
    }

    .credential-item:last-child {
      border-bottom: none;
    }

    .credential-item:hover {
      background: #fafcff;
    }

    .credential-label {
      font-weight: 600;
      font-size: 14px;
      color: #475569;
      width: 100px;
      flex-shrink: 0;
      display: flex;
      align-items: center;
      gap: 8px;
    }

    .credential-label .emoji-badge {
      font-size: 18px;
    }

    .credential-value {
      font-weight: 500;
      color: #0f172a;
      font-size: 15px;
      word-break: break-word;
      background: #f8fafc;
      padding: 4px 14px;
      border-radius: 40px;
      border: 1px solid #eef2f6;
      font-family: 'JetBrains Mono', 'Fira Code', monospace;
      letter-spacing: 0.2px;
    }

    .credential-value.password {
      background: #fef9f0;
      border-color: #fed7aa;
      color: #9a3412;
    }

    /* -------- BUTTON (elevated) -------- */
    .btn-wrapper {
      text-align: center;
      margin: 28px 0 20px;
    }

    .btn-login {
      display: inline-block;
      background: linear-gradient(135deg, #6366f1 0%, #4f46e5 100%);
      color: #ffffff !important;
      font-weight: 600;
      font-size: 16px;
      padding: 16px 44px;
      border-radius: 60px;
      text-decoration: none;
      box-shadow: 0 8px 20px -6px rgba(99, 102, 241, 0.4);
      transition: all 0.2s ease;
      border: 1px solid rgba(255, 255, 255, 0.15);
      letter-spacing: 0.2px;
    }

    .btn-login:hover {
      transform: translateY(-2px);
      box-shadow: 0 14px 28px -8px rgba(99, 102, 241, 0.5);
      background: linear-gradient(135deg, #4f46e5 0%, #4338ca 100%);
    }

    .btn-login:active {
      transform: scale(0.97);
    }

    .security-note {
      display: flex;
      align-items: center;
      gap: 10px;
      background: #f0fdf4;
      padding: 14px 18px;
      border-radius: 16px;
      margin-top: 20px;
      border: 1px solid #bbf7d0;
    }

    .security-note svg {
      flex-shrink: 0;
    }

    .security-note p {
      margin: 0;
      font-size: 14px;
      color: #166534;
    }

    .security-note strong {
      color: #14532d;
    }

    .footer {
      text-align: center;
      padding: 20px 32px 24px;
      font-size: 14px;
      color: #94a3b8;
      border-top: 1px solid #f1f5f9;
      background: #fafcff;
      border-radius: 0 0 24px 24px;
    }

    .footer .company-name {
      font-weight: 600;
      color: #475569;
    }

    .footer .footer-links {
      margin-top: 8px;
      display: flex;
      justify-content: center;
      gap: 20px;
      flex-wrap: wrap;
    }

    .footer .footer-links a {
      color: #94a3b8;
      text-decoration: none;
      font-size: 13px;
      transition: color 0.2s;
      border-bottom: 1px dotted transparent;
    }

    .footer .footer-links a:hover {
      color: #f97316;
      border-bottom-color: #f97316;
    }

    /* -------- RESPONSIVE -------- */
    @media only screen and (max-width: 600px) {
      body {
        padding: 12px 8px;
      }

      .email-container {
        border-radius: 20px;
      }

      .header {
        padding: 24px 16px 20px;
      }

      .header h1 {
        font-size: 24px;
      }

      .content {
        padding: 24px 18px 20px;
      }

      .credential-item {
        flex-wrap: wrap;
        padding: 14px 16px;
        gap: 4px;
      }

      .credential-label {
        width: 100%;
        font-size: 13px;
        margin-bottom: 2px;
      }

      .credential-value {
        width: 100%;
        font-size: 14px;
        padding: 6px 14px;
      }

      .btn-login {
        padding: 14px 32px;
        font-size: 15px;
        width: 100%;
      }

      .security-note {
        flex-direction: column;
        text-align: center;
        padding: 16px;
      }

      .footer {
        padding: 16px 18px 20px;
      }
    }

    @media only screen and (max-width: 400px) {
      .brand-icon span {
        font-size: 18px;
      }
      .header h1 {
        font-size: 20px;
      }
    }
  </style>
</head>
<body>

  <div class="email-container">

    <!-- HEADER with brand -->
    <div class="header">
      <div class="header-content">
        <div class="brand-icon">
          <span>Fillip</span>
          <span class="dot"></span>
          <span>Tech</span>
        </div>
        <h1>Welcome aboard! 🚀</h1>
        <span class="subhead">Your account is ready</span>
      </div>
    </div>

    <!-- MAIN CONTENT -->
    <div class="content">

      <!-- Greeting -->
      <div class="greeting">
        <h2>Hello <span>{{ $employee->name }}</span>,</h2>
        <p>We're thrilled to have you join the Fillip Technologies team. Your employee account has been created successfully.</p>
      </div>

      <div class="divider"></div>

      <!-- intro message -->
      <div class="message-box">
        <p>🔐 Below are your secure login credentials. Please keep them safe and use them to access your employee portal.</p>
      </div>

      <!-- CREDENTIALS - modern card -->
      <div class="credentials-card">
        <div class="credential-item">
          <span class="credential-label">
            <span class="emoji-badge">📧</span> Email
          </span>
          <span class="credential-value">{{ $employee->email }}</span>
        </div>
        <div class="credential-item">
          <span class="credential-label">
            <span class="emoji-badge">🔑</span> Password
          </span>
          <span class="credential-value password">{{ $planPassword }}</span>
        </div>
        <div class="credential-item">
          <span class="credential-label">
            <span class="emoji-badge">📱</span> Phone
          </span>
          <span class="credential-value">{{ $employee->phone }}</span>
        </div>
      </div>

      <!-- CTA BUTTON -->
      <div class="btn-wrapper">
        <a href="{{ url('https://growthmanagement.fillipsoftware.com/') }}" class="btn-login">
          ⚡ Go to Login
        </a>
      </div>

      <!-- Security note -->
      <div class="security-note">
        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
          <path d="M12 2L3 7V12.5C3 16.6 6.1 20.4 12 22C17.9 20.4 21 16.6 21 12.5V7L12 2Z" stroke="#166534" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/>
          <path d="M12 12L12 16" stroke="#166534" stroke-width="2" stroke-linecap="round"/>
          <circle cx="12" cy="9" r="1" fill="#166534"/>
        </svg>
        <p><strong>Pro tip:</strong> For security, please change your password immediately after your first login.</p>
      </div>

      <!-- extra note -->
      <p style="margin-top: 20px; color: #475569; font-size: 15px; text-align: center; border-top: 1px dashed #e2e8f0; padding-top: 20px;">
        We're excited to have you on board! If you have any questions, reach out to HR.
      </p>

    </div>

    <!-- FOOTER -->
    <div class="footer">
      <div class="company-name">© {{ date('Y') }} Fillip Technologies</div>
      <div class="footer-links">
        <a href="#">Privacy</a>
        <a href="#">Support</a>
        <a href="#">Growth Management</a>
      </div>
      <div style="margin-top: 8px; font-size: 12px; color: #cbd5e1;">
        This is an automated message, please do not reply.
      </div>
    </div>

  </div>

</body>
</html>
