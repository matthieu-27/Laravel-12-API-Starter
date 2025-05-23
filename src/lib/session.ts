import 'server-only';

import { cookies } from 'next/headers';
import { jwtVerify, SignJWT } from 'jose';
import type { JWTPayload } from 'jose';

import type { SessionPayload } from '@/lib/definition';
import { toast } from 'sonner';

const secretKey = process.env.SESSION_SECRET!;
const encodedKey = new TextEncoder().encode(secretKey);

export async function encrypt(payload: SessionPayload) {
  return new SignJWT(payload as JWTPayload)
    .setProtectedHeader({ alg: 'HS256' })
    .setIssuedAt()
    .setExpirationTime('7d')
    .sign(encodedKey);
}

export async function decrypt(session: string | undefined = '') {
  try {
    const { payload } = await jwtVerify(session, encodedKey, { algorithms: ['HS256'] });
    return payload as SessionPayload;
  } catch (error) {
    console.log('Failed to verify session');
    return null;
  }
}
 
export async function createSession(userId: string) {
  const expiresAt = new Date(Date.now() + 7 * 24 * 60 * 60 * 1000);
  const userPayload: SessionPayload = {
    userId: userId,
    issuedAt: Math.floor(Date.now() / 1000),
    expiresAt: Math.floor(Date.now() / 1000) + 7 * 24 * 60 * 60,
  };
  const session = await encrypt(userPayload);
  const cookieStore = await cookies();
 
  cookieStore.set('Authorization', `Bearer ${session}`);
  cookieStore.set('userId', userId);
  cookieStore.set('session', session, {
    httpOnly: true,
    secure: true,
    expires: expiresAt,
    sameSite: 'lax',
    path: '/',
  });
}
export async function updateSession() {
  const session = (await cookies()).get('session')?.value;
  const userId = (await cookies()).get('userId')?.value;
  const bearerToken = (await cookies()).get('Authorization')?.value;

  const payload = await decrypt(session);
   
    if (!session || !payload || !userId || !bearerToken) {
      toast.success('No session found.. Updating session');
    }
   
  const expiresAt = new Date(Date.now() + 7 * 24 * 60 * 60 * 1000);
    const cookieStore = await cookies();
    cookieStore.delete('session');

    cookieStore.('session', session, {
        httpOnly: true,
        secure: true,
        expires: expiresAt,
        sameSite: 'lax',
        path: '/',
    });
}

export async function deleteSession() {
  const cookieStore = await cookies();

  cookieStore.delete('session');
  cookieStore.delete('Authorization');
  cookieStore.delete('userId');

  toast.success('Session deleted');
}