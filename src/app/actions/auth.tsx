'use server';

import { toast } from 'sonner';

import { FormState, LoginFormSchema, LoginResponse } from '@/lib/definition';
import { createSession } from '@/lib/session';

export async function login(formState: FormState, formData: FormData) {
  const validatedFields = LoginFormSchema.safeParse({
    email: formData.get('email'),
    password: formData.get('password'),
  });

  if (!validatedFields.success) {
    return {
      errors: validatedFields.error.flatten().fieldErrors,
    };
  }

  const { email, password } = validatedFields.data;

  try {
    // Call the login API endpoint
    const response = await fetch('http://localhost:8000/api/tokens/create', {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
        Origin: 'http://localhost:3000',
      },
      body: JSON.stringify({ email, password }),
    });

    if (!response.ok) {
      const errorData = await response.json();
      toast.error('Server error:', errorData);
      return {
        errors: errorData.errors,
      };
    }

    const data: LoginResponse = await response.json();

    if (data.message === 'Login successful') {
      toast.success(data.message);
      await createSession(data.user!.id);
    }
  } catch (error: any) {
    toast.error('Network error:', error);
  }
}
