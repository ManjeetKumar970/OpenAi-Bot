curl https://openrouter.ai/api/v1/chat/completions \
  -H "Content-Type: application/json" \
  -H "Authorization: Bearer  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" \
  -d '{
  "model": "deepseek/deepseek-chat-v3-0324:free",
  "messages": [
    {
      "role": "user",
      "content": "What is the meaning of life?"
    }
  ]
  
}'


curl https://openrouter.ai/api/v1/chat/completions \
  -H "Content-Type: application/json" \
  -H "Authorization: Bearer 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" \
  -d '{
    "model": "deepseek/deepseek-chat-v3-0324:free",
    "messages": [
      {
        "role": "user",
        "content": "What is the meaning of life?"
      }
    ]
  }'
