-- Use the standard Division Level dashboard and permissions for this account.
-- Preserve its existing password, verification state, and organizational scope.
-- Safe to re-run; only the legacy role on the specified account is changed.
UPDATE users
SET position = 'division'
WHERE username = 'f@f.com'
  AND email = 'f@f.com'
  AND position = 'la_filipino';
