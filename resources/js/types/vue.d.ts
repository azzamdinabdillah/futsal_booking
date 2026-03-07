import { Page } from '@inertiajs/core';

declare module '@vue/runtime-core' {
    interface ComponentCustomProperties {
        $page: Page<{
            auth: {
                user: {
                    id: number;
                    name: string;
                    email: string;
                } | null;
            };
            [key: string]: any;
        }>;
    }
}
