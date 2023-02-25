use App\Models\Document;
use App\Models\Offices;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class UserTest extends TestCase
{
    use DatabaseTransactions;

    public function testRoleRelationship()
    {
        $user = Document::factory()->create();
        $role = Offices::factory()->create();

        $user->role()->associate($role)->save();

        $this->assertInstanceOf(Role::class, $user->role);
        $this->assertEquals($role->id, $user->role->id);
    }
}
