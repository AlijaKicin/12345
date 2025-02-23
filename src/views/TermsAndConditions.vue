<template>
  <div class="terms-and-conditions">
    <h1>Terms and Conditions</h1>
    <div class="content">
      <p>
        Welcome to Budget Buddy! By using our AI-powered financial assistant, you agree to the
        following terms and conditions:
      </p>
      <h2>1. Use of AI Assistant</h2>
      <p>
        The AI assistant provided by Budget Buddy is designed to offer financial advice and
        suggestions based on the data you provide. However, the AI is not a certified financial
        advisor, and its recommendations should not be considered as professional financial advice.
      </p>
      <h2>2. Limitation of Liability</h2>
      <p>
        Budget Buddy and its developers are not responsible for any financial decisions you make
        based on the AI assistant's suggestions. You are solely responsible for your financial
        actions and outcomes.
      </p>
      <h2>3. Data Privacy</h2>
      <p>
        Your data is securely stored and used only to provide you with personalized financial
        advice. We do not share your data with third parties without your consent.
      </p>
      <h2>4. Changes to Terms</h2>
      <p>
        We reserve the right to update or modify these terms and conditions at any time. Continued
        use of the AI assistant after any changes constitutes your acceptance of the new terms.
      </p>
      <p>
        If you have any questions or concerns, please contact us at
        <a href="mailto:support@budgetbuddy.com">support@budgetbuddy.com</a>.
      </p>
    </div>
  </div>
</template>

<script>
export default {
  name: 'TermsAndConditions',
}
</script>

<style scoped>
.terms-and-conditions {
  max-width: 800px;
  margin: 0 auto;
  padding: 20px;
  background: #f9f9f9;
  border-radius: 10px;
  box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
}

.terms-and-conditions h1 {
  text-align: center;
  color: #2a95bf;
}

.terms-and-conditions h2 {
  color: #295fa6;
  margin-top: 20px;
}

.terms-and-conditions p {
  line-height: 1.6;
  color: #333;
}

.terms-and-conditions a {
  color: #2a95bf;
  text-decoration: none;
}

.terms-and-conditions a:hover {
  text-decoration: underline;
}
</style>
