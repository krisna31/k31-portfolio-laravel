export interface User {
    id: number;
    name: string;
    email: string;
    is_admin: boolean;
    provider: string;
    email_verified_at: string;
}

export interface Note {
    id: number;
    user_id: number;
    title: string;
    body: string;
    created_at: string;
    updated_at: string;
}

export type PageProps<T extends Record<string, unknown> = Record<string, unknown>> = T & {
    auth: {
        user: User;
    };
    notes: Note[];
    note: Note;
    flash: {
        errors: string;
        success: string;
    }
};
