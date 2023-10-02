- create a `UserResource` class
````php
class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'attributes' => [
                'User_ID' => (int)$this->id,
                'Name' => (string)$this->name,
                'Email' => (string)$this->email,
                'isVerified' => (boolean)$this->verified,
                'isAdmin' => (boolean)$this->admin,
                'creationDate' => (string)$this->created_at,
                'lastChange' => (string)$this->updated_at,
                'deletedDate' => (string)$this->deleted_at,
            ],
            'relationships' => [],
            ]
        ];
    }

    # custom function to get original model attributes
    public static function originalAttribute($index)
    {
        $attributes = [
            'User_ID' => 'id',
            'Name' => 'name',
            'Email' => 'email',
            'isVerified' => 'verified',
            'isAdmin' => 'admin',
            'creationDate' => 'created_at',
            'lastChange' => 'updated_at',
            'deletedDate' => 'deleted_at',
        ];
        return $attributes[$index] ?? null;
    }
}
````